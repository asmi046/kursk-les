<?php

namespace App\Services\ProductList;

use App\Models\Product;

class CompareService extends AbstractProductListService
{
    public const MAX_ITEMS = 4;

    protected function sessionKey(): string
    {
        return 'compare.items';
    }

    protected function limit(): ?int
    {
        return self::MAX_ITEMS;
    }

    /**
     * Добавлен ли товар, или список уже заполнен.
     *
     * @return array{added: bool, limit_reached: bool}
     */
    public function toggleWithStatus(int $productId): array
    {
        if ($this->has($productId)) {
            $this->remove($productId);

            return ['added' => false, 'limit_reached' => false];
        }

        $added = $this->add($productId);

        return ['added' => $added, 'limit_reached' => ! $added];
    }

    /**
     * @return array<string, mixed>
     */
    protected function serializeProduct(Product $product): array
    {
        return array_merge(parent::serializeProduct($product), [
            'type' => $product->type,
            'material' => $product->material,
            'model' => $product->model,
            'dimensions' => trim($product->length.' × '.$product->wigth.' × '.$product->height, ' ×'),
            'weight' => $product->weight,
            'handle_exist' => (bool) $product->handle_exist,
            'rust_exist' => (bool) $product->rust_exist,
        ]);
    }
}
