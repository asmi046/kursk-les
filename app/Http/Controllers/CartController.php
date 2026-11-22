<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $cart->response(),
        ]);
    }

    public function add(AddToCartRequest $request, CartService $cart): JsonResponse
    {
        $cart->add(
            productId: (int) $request->input('product_id'),
            color: $request->input('color'),
            quantity: (int) ($request->input('quantity') ?? 1),
        );

        return response()->json([
            'success' => true,
            'data' => $cart->response(),
        ]);
    }

    public function update(Request $request, CartService $cart): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'color' => ['nullable', 'string', 'max:100'],
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $cart->update(
            productId: (int) $validated['product_id'],
            color: $validated['color'] ?? null,
            quantity: (int) $validated['quantity'],
        );

        return response()->json([
            'success' => true,
            'data' => $cart->response(),
        ]);
    }

    public function delete(Request $request, CartService $cart): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'color' => ['nullable', 'string', 'max:100'],
        ]);

        $cart->remove(
            productId: (int) $validated['product_id'],
            color: $validated['color'] ?? null,
        );

        return response()->json([
            'success' => true,
            'data' => $cart->response(),
        ]);
    }

    public function clear(CartService $cart): JsonResponse
    {
        $cart->clear();

        return response()->json([
            'success' => true,
            'data' => $cart->response(),
        ]);
    }
}
