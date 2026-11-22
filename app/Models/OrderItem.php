<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    public $fillable = [
        'order_id',
        'product_id',
        'product_slug',
        'product_name',
        'color',
        'price',
        'quantity',
        'weight_grams',
        'dimensions',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight_grams' => 'decimal:1',
        'dimensions' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
