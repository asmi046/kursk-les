<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShopSection extends Component
{
    public Collection $products;

    public function __construct()
    {
        $this->products = Product::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.shop-section');
    }
}
