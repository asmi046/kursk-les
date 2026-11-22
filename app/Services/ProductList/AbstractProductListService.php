<?php

namespace App\Services\ProductList;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

abstract class AbstractProductListService
{
    public function __construct(
        protected Session $session
    ) {}

    abstract protected function sessionKey(): string;

    /**
     * Максимальное количество товаров в списке (null — без лимита).
     */
    protected function limit(): ?int
    {
        return null;
    }

    /**
     * Переключить товар в списке. Возвращает true, если товар добавлен.
     */
    public function toggle(int $productId): bool
    {
        if ($this->has($productId)) {
            $this->remove($productId);

            return false;
        }

        return $this->add($productId);
    }

    public function add(int $productId): bool
    {
        $ids = $this->ids();

        if (in_array($productId, $ids, true)) {
            return true;
        }

        if ($this->limit() !== null && count($ids) >= $this->limit()) {
            return false;
        }

        $ids[] = $productId;

        $this->session->put($this->sessionKey(), array_values($ids));

        return true;
    }

    public function remove(int $productId): void
    {
        $ids = array_values(array_diff($this->ids(), [$productId]));

        $this->session->put($this->sessionKey(), $ids);
    }

    public function clear(): void
    {
        $this->session->forget($this->sessionKey());
    }

    public function has(int $productId): bool
    {
        return in_array($productId, $this->ids(), true);
    }

    /**
     * @return array<int, int>
     */
    public function ids(): array
    {
        return array_values(array_filter(
            $this->session->get($this->sessionKey(), []),
            'is_int'
        ));
    }

    public function count(): int
    {
        return count($this->ids());
    }

    public function isEmpty(): bool
    {
        return $this->ids() === [];
    }

    /**
     * Товары списка в порядке добавления.
     *
     * @return Collection<int, Product>
     */
    public function products(): Collection
    {
        $ids = $this->ids();

        if ($ids === []) {
            return collect();
        }

        $products = Product::whereIn('id', $ids)->get()->keyBy('id');

        return collect($ids)
            ->map(fn (int $id) => $products->get($id))
            ->filter()
            ->values();
    }

    /**
     * Ответ API для фронтенда.
     *
     * @return array{count: int, ids: array<int, int>, items: array<int, array<string, mixed>>}
     */
    public function response(): array
    {
        return [
            'count' => $this->count(),
            'ids' => $this->ids(),
            'items' => $this->products()
                ->map(fn (Product $product) => $this->serializeProduct($product))
                ->values()
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function serializeProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'title' => $product->title,
            'img' => $product->img ? asset('storage/'.$product->img) : null,
            'url' => route('product.show', $product->slug),
            'price' => (float) $product->price,
            'old_price' => $product->old_price !== null ? (float) $product->old_price : null,
            'characteristic' => trim($product->type.', '.$product->material, ' ,'),
            'colors' => $product->colors ?: [],
        ];
    }
}
