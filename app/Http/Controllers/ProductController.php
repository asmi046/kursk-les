<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $related = Product::query()
            ->where('type', $product->type)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('product', compact('product', 'related'));
    }
}
