<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $tovars = $this->buildProductQuery($request)
            ->paginate(9)
            ->withQueryString();

        return view('catalog', compact('tovars'));
    }

    public function category(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $tovars = $this->buildProductQuery($request, $category)
            ->paginate(9)
            ->withQueryString();

        return view('category', [
            'tovars' => $tovars,
            'category' => $category,
        ]);
    }

    private function buildProductQuery(Request $request, ?Category $category = null): Builder
    {
        $query = Product::query();

        if ($category) {
            $query->whereHas('categories', function (Builder $q) use ($category) {
                $q->where('categories.id', $category->id);
            });
        }

        if ($request->filled('material')) {
            $query->whereIn('material', (array) $request->input('material'));
        }

        if ($request->filled('color')) {
            $query->whereIn('color', (array) $request->input('color'));
        }

        if ($request->filled('handle_exist')) {
            $handleValues = (array) $request->input('handle_exist');
            $query->where('handle_exist', in_array('yes', $handleValues, true));
        }

        if ($request->filled('rust_exist')) {
            $rustValues = (array) $request->input('rust_exist');
            $query->where('rust_exist', in_array('yes', $rustValues, true));
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

        return $query;
    }
}
