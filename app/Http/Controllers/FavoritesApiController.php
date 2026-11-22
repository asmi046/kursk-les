<?php

namespace App\Http\Controllers;

use App\Services\ProductList\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritesApiController extends Controller
{
    public function index(FavoriteService $favorites): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $favorites->response(),
        ]);
    }

    public function toggle(Request $request, FavoriteService $favorites): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $added = $favorites->toggle((int) $validated['product_id']);

        return response()->json([
            'success' => true,
            'data' => $favorites->response() + ['added' => $added],
        ]);
    }

    public function delete(Request $request, FavoriteService $favorites): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $favorites->remove((int) $validated['product_id']);

        return response()->json([
            'success' => true,
            'data' => $favorites->response(),
        ]);
    }

    public function clear(FavoriteService $favorites): JsonResponse
    {
        $favorites->clear();

        return response()->json([
            'success' => true,
            'data' => $favorites->response(),
        ]);
    }
}
