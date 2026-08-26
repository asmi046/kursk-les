<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RealProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        $products = [
            [
                'title' => 'Набор «Лесная сказка»',
                'description' => 'Набор из натурального дерева для творчества. Включает разделочную доску и аксессуары для создания уникальных работ.',
                'img' => 'shop/magaz_1.webp',
                'slug' => 'nabor-lesnaya-skazka',
                'price' => 1290.00,
                'old_price' => 1590.00,
                'model' => 'КЛ-НС-001',
                'type' => 'Набор для творчества',
                'wigth' => '300 мм',
                'height' => '30 мм',
                'length' => '400 мм',
                'weight' => '0.8 кг',
                'material' => 'Дуб',
                'color' => 'Натуральный',
                'handle_exist' => false,
                'rust_exist' => false,
            ],

        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'shop/magaz_1.webp' => public_path('tmp/shop/magaz_1.webp'),
            'shop/magaz_2.webp' => public_path('tmp/shop/magaz_2.webp'),
            'shop/magaz_3.webp' => public_path('tmp/shop/magaz_3.webp'),
            'shop/magaz_4.webp' => public_path('tmp/shop/magaz_4.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                Storage::disk('public')->putFileAs(dirname($path), new File($source), basename($path));
            }
        }
    }
}
