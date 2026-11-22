<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CartPageController extends Controller
{
    public function index(): View
    {
        return view('cart.index');
    }

    public function thanks(): View
    {
        return view('cart.thanks', ['orderId' => (int) request('order_id')]);
    }
}
