<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    public $fillable = [
        'title',
        'description',
        'img',
        'galery',
        'slug',
        'price',
        'old_price',
        'model',
        'type',
        'wigth',
        'height',
        'length',
        'weight',
        'material',
        'color',
        'colors',
        'handle_exist',
        'rust_exist',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'handle_exist' => 'boolean',
        'rust_exist' => 'boolean',
        'galery' => 'array',
        'colors' => 'array',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withPivot('position')
            ->orderBy('category_product.position');
    }

    /**
     * Вес товара в граммах. В поле weight хранится строка вида «1.2 кг».
     */
    public function weightGrams(): float
    {
        $value = (float) preg_replace('/[^0-9.]/', '', (string) $this->weight);

        if ($value <= 0) {
            return 300.0;
        }

        return $value * 1000;
    }
}
