<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDelivery extends Model
{
    public const PROVIDER_CDEK = 'cdek';

    public const METHOD_PICKUP_POINT = 'pickup_point';

    public const METHOD_COURIER = 'courier';

    public $fillable = [
        'order_id',
        'provider',
        'method',
        'price',
        'tariff',
        'delivery_date_range',
        'city',
        'pickup_point_id',
        'pickup_point_address',
        'street',
        'house',
        'apartment',
        'raw_data',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'delivery_date_range' => 'array',
        'raw_data' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
