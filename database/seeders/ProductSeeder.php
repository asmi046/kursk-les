<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
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
            [
                'title' => 'Разделочная доска «Классика»',
                'description' => 'Классическая разделочная доска из массива дуба. Идеальна для ежедневного использования на кухне.',
                'img' => 'shop/magaz_2.webp',
                'slug' => 'razdelochnaya-doska-klassika',
                'price' => 990.00,
                'old_price' => null,
                'model' => 'КЛ-РД-002',
                'type' => 'Разделочная доска',
                'wigth' => '220 мм',
                'height' => '25 мм',
                'length' => '350 мм',
                'weight' => '0.7 кг',
                'material' => 'Дуб',
                'color' => 'Натуральный',
                'handle_exist' => true,
                'rust_exist' => false,
            ],
            [
                'title' => 'Торцевая доска «Шахматная»',
                'description' => 'Торцевая разделочная доска с шахматным узором. Изготовлена из твердых пород дерева по специальной технологии.',
                'img' => 'shop/magaz_3.webp',
                'slug' => 'tortsevaya-doska-shahmatnaya',
                'price' => 2490.00,
                'old_price' => 2990.00,
                'model' => 'КЛ-ТД-003',
                'type' => 'Торцевая доска',
                'wigth' => '280 мм',
                'height' => '40 мм',
                'length' => '380 мм',
                'weight' => '1.5 кг',
                'material' => 'Дуб, ясень',
                'color' => 'Натуральный',
                'handle_exist' => false,
                'rust_exist' => false,
            ],
            [
                'title' => 'Подставка под горячее',
                'description' => 'Подставка под горячее из натурального дерева. Защитит поверхность стола от горячей посуды.',
                'img' => 'shop/magaz_4.webp',
                'slug' => 'podstavka-pod-goryachee',
                'price' => 690.00,
                'old_price' => null,
                'model' => 'КЛ-ПГ-004',
                'type' => 'Подставка',
                'wigth' => '200 мм',
                'height' => '15 мм',
                'length' => '200 мм',
                'weight' => '0.3 кг',
                'material' => 'Бук',
                'color' => 'Натуральный',
                'handle_exist' => false,
                'rust_exist' => false,
            ],
        ];

        foreach ($products as $data) {
            $data['colors'] ??= ['Классический', 'Коричневый', 'Шоколадный', 'Графит'];
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
