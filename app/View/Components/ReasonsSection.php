<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReasonsSection extends Component
{
    public ?string $title;
    public Collection $reasons;
    public Collection $media;

    public function __construct()
    {
        $blocks = content_block('reasons');

        $this->title = $blocks->firstWhere('key', 'reasons-title')?->value;

        $this->reasons = $blocks->filter(fn($item) => str_starts_with($item->key, 'reason-'))->sortBy('order');

        $this->media = $blocks->filter(fn($item) => str_starts_with($item->key, 'media-'))->sortBy('order');
    }

    public function render(): View|Closure|string
    {
        return view('components.reasons-section');
    }
}
