<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public $fillable = [
        'name',
        'phone',
        'email',
        'comment',
        'items_summ',
        'delivery_price',
        'total_summ',
        'payment_id',
        'payment_status',
        'payment_status_text',
        'external_order_id',
        'session_id',
    ];

    protected $casts = [
        'items_summ' => 'decimal:2',
        'delivery_price' => 'decimal:2',
        'total_summ' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(OrderDelivery::class);
    }
}
