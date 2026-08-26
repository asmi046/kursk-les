<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AboutSection extends Component
{
    public ?string $title;
    public ?string $text;

    public function __construct()
    {
        $blocks = content_block('about');

        $this->title = $blocks->firstWhere('key', 'about-title')?->value;
        $this->text = $blocks->firstWhere('key', 'about-text')?->value;
    }

    public function render(): View|Closure|string
    {
        return view('components.about-section');
    }
}
