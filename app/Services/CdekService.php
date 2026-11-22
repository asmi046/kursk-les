<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CdekService
{
    protected function baseUrl(): string
    {
        return rtrim((string) config('cdek.base_url'), '/');
    }

    public function getAccessToken(bool $refresh = false): ?string
    {
        if (! $refresh) {
            $cached = Cache::get('cdek.access_token');
            if ($cached && $cached['expires_at'] > now()->timestamp) {
                return $cached['access_token'];
            }
        }

        try {
            $response = Http::asForm()->post($this->baseUrl().'/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('cdek.login'),
                'client_secret' => config('cdek.password'),
            ]);
        } catch (ConnectionException $e) {
            Log::channel('sdek')->error('CDEK auth connection error: '.$e->getMessage());

            return null;
        }

        if (! $response->successful()) {
            Log::channel('sdek')->error('CDEK auth failed: '.$response->body());

            return null;
        }

        $data = $response->json();
        $ttl = (int) ($data['expires_in'] ?? 3600);

        Cache::put('cdek.access_token', [
            'access_token' => $data['access_token'],
            'expires_at' => now()->timestamp + $ttl - 60,
        ], now()->addSeconds($ttl));

        return $data['access_token'];
    }

    /**
     * Авторизованный запрос к API СДЭК с однократным обновлением токена при 401.
     */
    protected function request(callable $callback, string $action): ?Response
    {
        $token = $this->getAccessToken();

        if (! $token) {
            return null;
        }

        try {
            /** @var Response $response */
            $response = $callback($this->http($token));
        } catch (ConnectionException $e) {
            Log::channel('sdek')->error("CDEK {$action} connection error: ".$e->getMessage());

            return null;
        }

        if ($response->status() === 401) {
            $token = $this->getAccessToken(true);

            if (! $token) {
                return null;
            }

            try {
                $response = $callback($this->http($token));
            } catch (ConnectionException $e) {
                Log::channel('sdek')->error("CDEK {$action} retry connection error: ".$e->getMessage());

                return null;
            }
        }

        if (! $response->successful()) {
            Log::channel('sdek')->error("CDEK {$action} failed: ".$response->body());

            return null;
        }

        return $response;
    }

    protected function http(string $token): PendingRequest
    {
        return Http::withToken($token)->acceptJson();
    }

    public function getCities(array $params = []): ?array
    {
        $response = $this->request(
            fn (PendingRequest $http) => $http->get($this->baseUrl().'/location/cities', $params),
            'cities'
        );

        return $response?->json();
    }

    public function getDeliveryPoints(array $params = []): ?array
    {
        $response = $this->request(
            fn (PendingRequest $http) => $http->get($this->baseUrl().'/deliverypoints', $params),
            'delivery points'
        );

        return $response?->json();
    }

    public function getAvailableTariffs(array $data): ?array
    {
        $response = $this->request(
            fn (PendingRequest $http) => $http->post($this->baseUrl().'/calculator/tarifflist', $data),
            'available tariffs'
        );

        return $response?->json();
    }

    /**
     * Лучший тариф СДЭК для режима доставки: 4 — до ПВЗ, 3 — курьер.
     * Вес принимается в граммах.
     */
    public function getBestTariffByMode(string|int $toCode, float|int $weightGrams, int $deliveryMode): ?array
    {
        $weightKg = max(round((float) $weightGrams / 1000, 3), 0.1);

        $tariffs = $this->getAvailableTariffs([
            'from_location' => [
                'code' => (string) config('cdek.sender_city_code'),
            ],
            'to_location' => [
                'code' => (string) $toCode,
            ],
            'packages' => [
                [
                    'weight' => $weightKg,
                ],
            ],
        ]);

        if (is_null($tariffs)) {
            return null;
        }

        $filtered = array_values(array_filter(
            $tariffs['tariff_codes'] ?? [],
            fn (array $tariff) => (int) ($tariff['delivery_mode'] ?? 0) === $deliveryMode
                && isset($tariff['delivery_sum'])
        ));

        if ($filtered === []) {
            return [];
        }

        usort($filtered, fn (array $left, array $right) => (float) $left['delivery_sum'] <=> (float) $right['delivery_sum']);

        return $filtered[0];
    }

    public function registerOrder(array $payload): ?array
    {
        $response = $this->request(
            fn (PendingRequest $http) => $http->post($this->baseUrl().'/orders', $payload),
            'register order'
        );

        $body = $response?->json();

        if ($body !== null) {
            Log::channel('sdek')->info('CDEK register order response', [
                'order_payload' => $payload,
                'response' => $body,
            ]);
        }

        return $body;
    }

    public function getOrder(string $uuid): ?array
    {
        $response = $this->request(
            fn (PendingRequest $http) => $http->get($this->baseUrl().'/orders/'.$uuid),
            'get order'
        );

        return $response?->json();
    }
}
