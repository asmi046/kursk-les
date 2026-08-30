<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $razdel = Category::where('slug', 'razdelochnye-doski')->first();
        $nabory = Category::where('slug', 'nabory-dlya-tvorchestva')->first();
        $torc = Category::where('slug', 'tortsevye-izdeliya')->first();
        $podstavki = Category::where('slug', 'podstavki-i-podacha')->first();

        $mapping = [
            'Набор разделочных досок' => [$nabory?->id, $razdel?->id],
            'Сувенирная разделочная доска' => [$razdel?->id, $torc?->id],
            'Разделочная доска' => [$razdel?->id],
            'Торцевая доска' => [$torc?->id, $razdel?->id],
            'Подставка под горячее' => [$podstavki?->id],
            'Доска для подачи' => [$podstavki?->id, $razdel?->id],
            'Поднос' => [$podstavki?->id],
            'Подставка' => [$podstavki?->id],
        ];

        $rows = [];
        $products = Product::all();

        foreach ($products as $product) {
            $title = $product->title;

            $matchedCategories = [];
            foreach ($mapping as $key => $categoryIds) {
                if (str_contains($title, $key)) {
                    foreach ($categoryIds as $catId) {
                        if ($catId && ! in_array($catId, $matchedCategories)) {
                            $matchedCategories[] = $catId;
                        }
                    }
                }
            }

            if (empty($matchedCategories) && $razdel) {
                $matchedCategories[] = $razdel->id;
            }

            foreach ($matchedCategories as $categoryId) {
                $rows[] = [
                    'category_id' => $categoryId,
                    'product_id' => $product->id,
                    'position' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($rows as $row) {
            DB::table('category_product')->updateOrInsert(
                [
                    'category_id' => $row['category_id'],
                    'product_id' => $row['product_id'],
                ],
                [
                    'position' => $row['position'],
                    'updated_at' => now(),
                ]
            );
        }
    }
}
