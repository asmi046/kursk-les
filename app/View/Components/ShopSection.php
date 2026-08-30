<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ShopSection extends Component
{
    public Collection $products;

    public function __construct()
    {
        $this->products = Product::inRandomOrder()->limit(8)->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.shop-section');
    }
}
