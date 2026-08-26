<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use Illuminate\Http\Request;

class RestaurantOfferController extends Controller
{
    public function index()
    {
        $offers = ContentBlock::group('restaurant_offer');

        return view('restaurant-offer', [
            'title' => 'Эксклюзивное предложение для Кафэ и ресторанов',
            'offers' => $offers,
        ]);
    }
}
