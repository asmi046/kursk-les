<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ContentBlock extends Model
{
    public $fillable = [
        'group',
        'key',
        'title',
        'value',
        'icon',
        'order',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function group(string $group): Collection
    {
        $cacheKey = "content_blocks_{$group}";

        $items = Cache::rememberForever($cacheKey, function () use ($group) {
            return self::where('group', $group)->orderBy('order')->get()->toArray();
        });

        return self::hydrate($items);
    }
}
