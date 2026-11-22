<?php

namespace App\Http\Controllers;

use App\DTO\CheckoutData;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request, OrderService $orders, CartService $cart): JsonResponse
    {
        if ($cart->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => ['Корзина пуста.'],
            ]);
        }

        $order = $orders->checkout(CheckoutData::fromRequest($request));

        $cart->clear();

        /*
        |----------------------------------------------------------------------
        | ОПЛАТА (YooKassa) — закомментировано до подключения боевых доступов.
        |
        | Здесь вернуть confirmation_url платежа, фронт перенаправит покупателя:
        |
        | return response()->json([
        |     'success' => true,
        |     'data' => [
        |         'order_id' => $order->id,
        |         'payment_url' => $payment->getConfirmation()->getConfirmationUrl(),
        |     ],
        | ]);
        |----------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $order->id,
                'total_summ' => (float) $order->total_summ,
            ],
        ]);
    }
}
