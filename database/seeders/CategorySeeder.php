<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        $categories = [
            [
                'title' => 'Наборы для творчества',
                'slug' => 'nabory-dlya-tvorchestva',
                'description' => 'Наборы для творчества из натурального дерева',
                'img' => 'categories/cat_nabors.webp',
            ],
            [
                'title' => 'Разделочные доски',
                'slug' => 'razdelochnye-doski',
                'description' => 'Разделочные доски из массива дуба, бука и ясеня',
                'img' => 'categories/cat_razdel.webp',
            ],
            [
                'title' => 'Торцевые изделия',
                'slug' => 'tortsevye-izdeliya',
                'description' => 'Торцевые изделия из твердых пород дерева',
                'img' => 'categories/cat_torcevie.webp',
            ],
            [
                'title' => 'Подставки и подача',
                'slug' => 'podstavki-i-podacha',
                'description' => 'Подставки и элементы подачи из дерева',
                'img' => 'categories/cat_podacha.webp',
            ],
        ];

        foreach ($categories as $data) {
            Category::create($data);
        }
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'categories/cat_nabors.webp' => public_path('tmp/categories/cat_nabors.webp'),
            'categories/cat_razdel.webp' => public_path('tmp/categories/cat_razdel.webp'),
            'categories/cat_torcevie.webp' => public_path('tmp/categories/cat_torcevie.webp'),
            'categories/cat_podacha.webp' => public_path('tmp/categories/cat_podacha.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                Storage::disk('public')->putFileAs(dirname($path), new File($source), basename($path));
            }
        }
    }
}
