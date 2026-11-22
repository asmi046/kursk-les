<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $fillable = [
        'title',
        'slug',
        'description',
        'img',
        'gallery',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
