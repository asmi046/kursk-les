<?php

namespace App\DTO;

use App\Models\OrderDelivery;

final readonly class DeliveryData
{
    public function __construct(
        public string $method,
        public ?string $price,
        public ?string $city,
        public ?string $pickupPointId,
        public ?string $pickupPointAddress,
        public ?string $street,
        public ?string $house,
        public ?string $apartment,
        public ?array $rawData,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            method: (string) ($data['method'] ?? ''),
            price: isset($data['price']) ? (string) $data['price'] : null,
            city: $data['city'] ?? null,
            pickupPointId: $data['pickup_point_id'] ?? null,
            pickupPointAddress: $data['pickup_point_address'] ?? null,
            street: $data['street'] ?? null,
            house: $data['house'] ?? null,
            apartment: $data['apartment'] ?? null,
            rawData: $data['raw_data'] ?? null,
        );
    }

    public function toAttributes(): array
    {
        return [
            'provider' => OrderDelivery::PROVIDER_CDEK,
            'method' => $this->method,
            'price' => $this->price,
            'city' => $this->city,
            'pickup_point_id' => $this->pickupPointId,
            'pickup_point_address' => $this->pickupPointAddress,
            'street' => $this->street,
            'house' => $this->house,
            'apartment' => $this->apartment,
            'raw_data' => $this->rawData,
        ];
    }
}
