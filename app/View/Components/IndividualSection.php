<?php

namespace App\View\Components;

use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IndividualSection extends Component
{
    public ?string $title;
    public ?string $text;
    public ?string $maxLink;
    public ?string $tgLink;
    public ?string $maxImg;
    public ?string $tgImg;
    public Collection $slides;

    public function __construct()
    {
        $blocks = content_block('individual');

        $this->title = $blocks->firstWhere('key', 'title')?->value;
        $this->text = $blocks->firstWhere('key', 'text')?->value;
        $this->maxLink = $blocks->firstWhere('key', 'max_lnk')?->value;
        $this->tgLink = $blocks->firstWhere('key', 'tg_lnk')?->value;
        $this->maxImg = $blocks->firstWhere('key', 'max_lnk')?->img;
        $this->tgImg = $blocks->firstWhere('key', 'tg_lnk')?->img;

        $this->slides = $blocks
            ->filter(fn($item) => in_array($item->key, ['slider-1', 'slider-2']))
            ->values();
    }

    public function render(): View|Closure|string
    {
        return view('components.individual-section');
    }
}
