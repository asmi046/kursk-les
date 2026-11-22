<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CdekService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function cities(Request $request, CdekService $cdek): JsonResponse
    {
        $params = array_filter([
            'country_codes' => $request->input('country_codes', 'RU'),
            'city' => $request->input('city'),
            'page' => $request->input('page', 0),
            'size' => $request->input('size', 20),
        ], fn ($value) => $value !== null && $value !== '');

        $cities = $cdek->getCities($params);

        if (is_null($cities)) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось получить список городов',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => $cities,
        ]);
    }

    /**
     * Пункты выдачи СДЭК в городе.
     */
    public function pickupPoints(Request $request, CdekService $cdek): JsonResponse
    {
        $validated = $request->validate([
            'city_code' => ['required'],
        ]);

        $points = $cdek->getDeliveryPoints([
            'city_code' => $validated['city_code'],
            'type' => 'PVZ',
            'is_receiving' => 'true',
            'size' => 500,
        ]);

        if (is_null($points)) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось получить пункты выдачи',
            ], 500);
        }

        $normalized = array_values(array_map(fn (array $point) => [
            'code' => $point['code'] ?? null,
            'name' => $point['name'] ?? null,
            'address' => $point['location']['address'] ?? null,
            'latitude' => $point['location']['latitude'] ?? null,
            'longitude' => $point['location']['longitude'] ?? null,
            'work_time' => $point['work_time'] ?? null,
            'city' => $point['location']['city'] ?? null,
        ], $points));

        return response()->json([
            'success' => true,
            'data' => $normalized,
        ]);
    }

    /**
     * Лучший тариф СДЭК для корзины: режим 4 — до ПВЗ, 3 — курьер.
     */
    public function tariffs(Request $request, CartService $cart, CdekService $cdek): JsonResponse
    {
        $validated = $request->validate([
            'to_code' => ['required'],
            'delivery_mode' => ['required', 'integer', 'in:3,4'],
        ]);

        $tariff = $cdek->getBestTariffByMode(
            toCode: $validated['to_code'],
            weightGrams: $cart->weightGrams(),
            deliveryMode: (int) $validated['delivery_mode'],
        );

        if (is_null($tariff)) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось рассчитать стоимость доставки',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => $tariff,
        ]);
    }
}
