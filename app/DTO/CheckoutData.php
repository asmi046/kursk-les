<?php

namespace App\DTO;

use Illuminate\Http\Request;

final readonly class CheckoutData
{
    /**
     * @param  array<int, CheckoutItemData>  $items
     */
    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public ?string $comment,
        public DeliveryData $delivery,
        public array $items,
        public string $sessionId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $validated = $request->validated();

        $items = array_map(
            static fn (array $item) => CheckoutItemData::fromArray($item),
            $validated['items'] ?? [],
        );

        return new self(
            name: (string) ($validated['name'] ?? ''),
            phone: (string) ($validated['phone'] ?? ''),
            email: (string) ($validated['email'] ?? ''),
            comment: $validated['comment'] ?? null,
            delivery: DeliveryData::fromArray($validated['delivery'] ?? []),
            items: $items,
            sessionId: $request->session()->getId(),
        );
    }
}
