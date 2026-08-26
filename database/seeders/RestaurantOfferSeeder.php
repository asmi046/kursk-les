<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use DB;

class RestaurantOfferSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        DB::table('content_blocks')->insert([
            [
                'group' => 'restaurant_offer',
                'key' => 'offer-1',
                'title' => null,
                'value' => 'Наша продукция создается на собственном производстве, что позволяет соблюдать сроки исполнения заказа и предоставлять скидки для оптовых заказчиков',
                'img' => 'restaurant/p_1.webp',
                'icon' => null,
                'order' => 1,
            ],
            [
                'group' => 'restaurant_offer',
                'key' => 'offer-2',
                'title' => null,
                'value' => 'Высокое качество продукции мы гарантируем за счет использования высококачественной древесины, соответствующей требованиям просушки, хранящейся в соответствующих условиях и тщательно проработанной технологии производства',
                'img' => 'restaurant/p_2.webp',
                'icon' => null,
                'order' => 2,
            ],
            [
                'group' => 'restaurant_offer',
                'key' => 'offer-3',
                'title' => null,
                'value' => 'Нестандартные решения нам тоже по силам. Вместе с заказчиком мы разрабатываем уникальную форму, брендируем фирменным клеймом ресторана, создаем наборы, соответствующие концепции компании',
                'img' => 'restaurant/p_3.webp',
                'icon' => null,
                'order' => 3,
            ],
            [
                'group' => 'restaurant_offer',
                'key' => 'offer-4',
                'title' => null,
                'value' => 'Ассортимент для ресторанов:
Разделочные доски
Доски для подачи
Посуда для подачи роллов
Подносы
Салфетницы
Счетницы
Столы из дерева и эпоксидной смолы',
                'img' => 'restaurant/p_4.webp',
                'icon' => null,
                'order' => 4,
            ],
        ]);
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'restaurant/p_1.webp' => public_path('tmp/restoran/p_1.webp'),
            'restaurant/p_2.webp' => public_path('tmp/restoran/p_2.webp'),
            'restaurant/p_3.webp' => public_path('tmp/restoran/p_3.webp'),
            'restaurant/p_4.webp' => public_path('tmp/restoran/p_4.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                Storage::disk('public')->putFileAs(dirname($path), new \Illuminate\Http\File($source), basename($path));
            }
        }
    }
}
