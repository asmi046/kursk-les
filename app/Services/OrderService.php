<?php

namespace App\Services;

use App\DTO\CheckoutData;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Оформить заказ: заказ + позиции + доставка в одной транзакции.
     */
    public function checkout(CheckoutData $data): Order
    {
        return DB::transaction(function () use ($data) {
            $products = Product::whereIn('id', array_column($data->items, 'productId'))
                ->get()
                ->keyBy('id');

            $itemsSumm = 0.0;
            $orderItems = [];

            foreach ($data->items as $item) {
                $product = $products->get($item->productId);

                if (! $product) {
                    continue;
                }

                $price = (float) $product->price;
                $itemsSumm += $price * $item->quantity;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_slug' => $product->slug,
                    'product_name' => $product->title,
                    'color' => $item->color,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'weight_grams' => $product->weightGrams(),
                    'dimensions' => [
                        'length' => preg_replace('/[^0-9.]/', '', (string) $product->length),
                        'wigth' => preg_replace('/[^0-9.]/', '', (string) $product->wigth),
                        'height' => preg_replace('/[^0-9.]/', '', (string) $product->height),
                    ],
                ];
            }

            $deliveryPrice = (float) ($data->delivery->price ?? 0);

            $order = Order::create([
                'name' => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'comment' => $data->comment,
                'items_summ' => $itemsSumm,
                'delivery_price' => $deliveryPrice,
                'total_summ' => $itemsSumm + $deliveryPrice,
                'session_id' => $data->sessionId,
            ]);

            $order->items()->createMany($orderItems);

            $deliveryAttributes = $data->delivery->toAttributes();
            $deliveryAttributes['tariff'] = $data->delivery->rawData['tariff']['tariff_name'] ?? null;
            $deliveryAttributes['delivery_date_range'] = [
                $data->delivery->rawData['tariff']['delivery_date_min'] ?? null,
                $data->delivery->rawData['tariff']['delivery_date_max'] ?? null,
            ];

            $order->delivery()->create($deliveryAttributes);

            /*
            |----------------------------------------------------------------------
            | ОПЛАТА (YooKassa) — закомментировано до подключения боевых доступов.
            |
            | После регистрации в YooKassa:
            |   1. composer require yoomoney/yookassa-sdk-php
            |   2. добавить config/yookassa.php и YooKassaService (образец —
            |      app/Services/YooKassaService.php в проекте 1_voentorg_laravel);
            |   3. здесь зарегистрировать платёж и записать payment_id;
            |   4. раскомментировать роут pay_hook и исключение CSRF для него.
            |----------------------------------------------------------------------
            */

            DB::afterCommit(function () use ($order) {
                event(new OrderCreated($order));
            });

            return $order;
        });
    }
}
