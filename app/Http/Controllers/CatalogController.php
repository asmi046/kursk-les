<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('material')) {
            $materials = (array) $request->input('material');
            $query->whereIn('material', $materials);
        }

        if ($request->filled('color')) {
            $colors = (array) $request->input('color');
            $query->whereIn('color', $colors);
        }

        if ($request->filled('handle_exist')) {
            $handleValues = (array) $request->input('handle_exist');
            $handleBool = in_array('yes', $handleValues, true);
            $query->where('handle_exist', $handleBool);
        }

        if ($request->filled('rust_exist')) {
            $rustValues = (array) $request->input('rust_exist');
            $rustBool = in_array('yes', $rustValues, true);
            $query->where('rust_exist', $rustBool);
        }

        $sort = $request->input('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        $tovars = $query->paginate(9)->withQueryString();

        return view('catalog', compact('tovars'));
    }
}
