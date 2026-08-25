<?php

namespace App\View\Components;

use App\Models\ContentBlock;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdvantagesSection extends Component
{
    public function __construct()
    {
        $this->items = content_block('advantages');
    }

    public function render(): View|Closure|string
    {
        return view('components.advantages-section', [
            'items' => $this->items,
        ]);
    }
}
