<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class CartService
{
    protected const SESSION_KEY = 'cart.items';

    public function __construct(
        protected Session $session
    ) {}

    /**
     * Добавить позицию в корзину. Одна позиция — товар + цвет.
     */
    public function add(int $productId, ?string $color, int $quantity = 1): void
    {
        $items = $this->rawItems();

        $key = $this->key($productId, $color);

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $items[$key] = [
                'product_id' => $productId,
                'color' => $color,
                'quantity' => $quantity,
            ];
        }

        $this->session->put(self::SESSION_KEY, $items);
    }

    public function update(int $productId, ?string $color, int $quantity): void
    {
        $items = $this->rawItems();
        $key = $this->key($productId, $color);

        if (! isset($items[$key])) {
            return;
        }

        if ($quantity <= 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        $this->session->put(self::SESSION_KEY, $items);
    }

    public function remove(int $productId, ?string $color): void
    {
        $items = $this->rawItems();

        unset($items[$this->key($productId, $color)]);

        $this->session->put(self::SESSION_KEY, $items);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    /**
     * Позиции корзины, обогащённые данными товара.
     *
     * @return Collection<int, array{key: string, product: Product, color: ?string, quantity: int, price: float, summ: float}>
     */
    public function items(): Collection
    {
        $raw = $this->rawItems();

        if ($raw === []) {
            return collect();
        }

        $products = Product::whereIn('id', array_column($raw, 'product_id'))
            ->get()
            ->keyBy('id');

        $items = [];

        foreach ($raw as $key => $position) {
            $product = $products->get($position['product_id']);

            if (! $product) {
                continue;
            }

            $items[] = [
                'key' => $key,
                'product' => $product,
                'color' => $position['color'],
                'quantity' => $position['quantity'],
                'price' => (float) $product->price,
                'summ' => (float) $product->price * $position['quantity'],
            ];
        }

        return collect($items);
    }

    public function count(): int
    {
        return (int) array_sum(array_column($this->rawItems(), 'quantity'));
    }

    public function isEmpty(): bool
    {
        return $this->rawItems() === [];
    }

    public function itemsSumm(): float
    {
        return (float) $this->items()->sum('summ');
    }

    /**
     * Общий вес корзины в граммах (для расчёта тарифов СДЭК).
     */
    public function weightGrams(): float
    {
        return (float) $this->items()
            ->reduce(fn (float $carry, array $item) => $carry + $item['product']->weightGrams() * $item['quantity'], 0.0);
    }

    /**
     * Ответ API корзины для фронтенда.
     *
     * @return array{count: int, items_summ: float, weight_grams: float, items: array<int, array<string, mixed>>}
     */
    public function response(): array
    {
        return [
            'count' => $this->count(),
            'items_summ' => $this->itemsSumm(),
            'weight_grams' => $this->weightGrams(),
            'items' => $this->items()
                ->map(fn (array $item) => $this->serializeItem($item))
                ->values()
                ->all(),
        ];
    }

    protected function serializeItem(array $item): array
    {
        /** @var Product $product */
        $product = $item['product'];

        return [
            'key' => $item['key'],
            'product_id' => $product->id,
            'slug' => $product->slug,
            'title' => $product->title,
            'img' => $product->img ? asset('storage/'.$product->img) : null,
            'url' => route('product.show', $product->slug),
            'price' => $item['price'],
            'summ' => $item['summ'],
            'color' => $item['color'],
            'colors' => $product->colors ?: [],
            'characteristic' => trim($product->type.', '.$product->material, ' ,'),
            'quantity' => $item['quantity'],
        ];
    }

    protected function key(int $productId, ?string $color): string
    {
        return $productId.'|'.($color ?? '');
    }

    /**
     * @return array<string, array{product_id: int, color: ?string, quantity: int}>
     */
    protected function rawItems(): array
    {
        return $this->session->get(self::SESSION_KEY, []);
    }
}
