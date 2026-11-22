<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDelivery;

class CdekOrderBuilder
{
    public function __construct(
        protected CdekService $cdekService
    ) {}

    public function createOrder(Order $order): ?array
    {
        $payload = $this->buildOrderPayload($order);

        if (! $payload) {
            return null;
        }

        return $this->cdekService->registerOrder($payload);
    }

    protected function buildOrderPayload(Order $order): ?array
    {
        $delivery = $order->delivery;

        if (! $delivery || $delivery->provider !== OrderDelivery::PROVIDER_CDEK) {
            return null;
        }

        $raw = $delivery->raw_data ?? [];

        $payload = [
            'type' => '1',
            'number' => 'ORD-'.$order->id.'-'.now()->format('Hi'),
            'tariff_code' => $raw['tariff']['tariff_code'] ?? null,
            'comment' => "Заказ #{$order->id}. {$order->name}. {$order->phone}",
            'shipment_point' => config('cdek.shipment_point') ?: null,
            'from_location' => config('cdek.shipment_point') ? null : [
                'code' => (int) config('cdek.sender_city_code'),
            ],
            'sender' => $this->buildSender(),
            'recipient' => $this->buildRecipient($order, $delivery),
            'packages' => $this->buildPackages($order),
        ];

        if ($delivery->method === OrderDelivery::METHOD_PICKUP_POINT) {
            $payload['delivery_point'] = $delivery->pickup_point_id;
        } elseif ($delivery->method === OrderDelivery::METHOD_COURIER) {
            $payload['to_location'] = [
                'code' => $raw['selectedCity']['code'] ?? null,
                'address' => [
                    'street' => $delivery->street ?? '',
                    'house' => $delivery->house ?? '',
                    'flat' => $delivery->apartment ?? '',
                ],
            ];
            $payload['delivery_recipient_cost'] = [
                'value' => (float) $delivery->price,
                'vat_sum' => 0,
            ];
        }

        return $payload;
    }

    protected function buildSender(): array
    {
        return [
            'company' => config('cdek.sender.company'),
            'name' => config('cdek.sender.name'),
            'email' => config('cdek.sender.email'),
            'phones' => [
                ['number' => config('cdek.sender.phone')],
            ],
        ];
    }

    protected function buildRecipient(Order $order, OrderDelivery $delivery): array
    {
        $recipient = [
            'name' => $order->name,
            'phones' => [
                ['number' => preg_replace('/[^0-9]/', '', $order->phone)],
            ],
        ];

        if ($order->email) {
            $recipient['email'] = $order->email;
        }

        if ($delivery->method === OrderDelivery::METHOD_COURIER) {
            $recipient['address'] = [
                'street' => $delivery->street ?? '',
                'house' => $delivery->house ?? '',
                'flat' => $delivery->apartment ?? '',
            ];
        }

        return $recipient;
    }

    protected function buildPackages(Order $order): array
    {
        $cdekItems = [];
        $totalWeight = 0.0;

        foreach ($order->items as $item) {
            $weight = (float) $item->weight_grams > 0 ? (float) $item->weight_grams : 300.0;
            $totalWeight += $weight * $item->quantity;

            $cdekItems[] = [
                'ware_key' => $item->product_slug ?: (string) $item->product_id,
                'name' => $item->product_name.($item->color ? ' ('.$item->color.')' : ''),
                'cost' => (float) $item->price,
                'weight' => round($weight, 3),
                'amount' => $item->quantity,
                'payment' => [
                    'value' => 0,
                    'vat_sum' => 0,
                ],
            ];
        }

        return [
            [
                'number' => 'PKG-'.$order->id,
                'weight' => max(round($totalWeight / 1000, 3), 0.1),
                'items' => $cdekItems,
            ],
        ];
    }
}
