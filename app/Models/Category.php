<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    public $fillable = [
        'title',
        'slug',
        'description',
        'img',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product')
            ->withPivot('position')
            ->orderBy('category_product.position');
    }
}
