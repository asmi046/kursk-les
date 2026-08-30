<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CategoriesSection extends Component
{
    public Collection $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.categories-section');
    }
}
