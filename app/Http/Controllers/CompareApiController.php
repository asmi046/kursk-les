<?php

namespace App\Http\Controllers;

use App\Services\ProductList\CompareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompareApiController extends Controller
{
    public function index(CompareService $compare): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $compare->response() + ['limit' => CompareService::MAX_ITEMS],
        ]);
    }

    public function toggle(Request $request, CompareService $compare): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $status = $compare->toggleWithStatus((int) $validated['product_id']);

        return response()->json([
            'success' => true,
            'data' => $compare->response() + $status + ['limit' => CompareService::MAX_ITEMS],
        ]);
    }

    public function delete(Request $request, CompareService $compare): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $compare->remove((int) $validated['product_id']);

        return response()->json([
            'success' => true,
            'data' => $compare->response() + ['limit' => CompareService::MAX_ITEMS],
        ]);
    }

    public function clear(CompareService $compare): JsonResponse
    {
        $compare->clear();

        return response()->json([
            'success' => true,
            'data' => $compare->response() + ['limit' => CompareService::MAX_ITEMS],
        ]);
    }
}
