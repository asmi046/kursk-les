<?php

namespace App\DTO;

final readonly class CheckoutItemData
{
    public function __construct(
        public int $productId,
        public ?string $color,
        public int $quantity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: (int) ($data['product_id'] ?? 0),
            color: $data['color'] ?? null,
            quantity: max((int) ($data['quantity'] ?? 1), 1),
        );
    }
}
