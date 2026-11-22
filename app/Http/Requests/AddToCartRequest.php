<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'color' => ['nullable', 'string', 'max:100', $this->colorRule()],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ];
    }

    /**
     * Цвет должен входить в список доступных цветов товара.
     */
    protected function colorRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            if ($value === null) {
                return;
            }

            $product = Product::find($this->input('product_id'));

            if ($product && $product->colors && ! in_array($value, $product->colors)) {
                $fail('Выбранный цвет недоступен для этого товара.');
            }
        };
    }
}
