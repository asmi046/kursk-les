<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProductListPageController extends Controller
{
    public function favorites(): View
    {
        return view('favorites.index');
    }

    public function compare(): View
    {
        return view('compare.index');
    }
}
