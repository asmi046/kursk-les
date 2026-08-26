<?php

namespace App\View\Components;

use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RestaurantOfferSection extends Component
{
    public Collection $offers;

    public function __construct()
    {
        $this->offers = ContentBlock::group('restaurant_offer');
    }

    public function render(): View|Closure|string
    {
        return view('components.restaurant-offer-section');
    }
}
