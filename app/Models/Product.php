<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'title',
        'description',
        'img',
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
        'handle_exist',
        'rust_exist',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'handle_exist' => 'boolean',
        'rust_exist' => 'boolean',
    ];
}
