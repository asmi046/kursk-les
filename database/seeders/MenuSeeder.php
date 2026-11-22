<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            ['menu_name' => 'Главное меню', 'title' => 'О нас', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'Каталог', 'order' => 2, 'lnk' => '/catalog'],
            ['menu_name' => 'Главное меню', 'title' => 'Оплата и доставка', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'Для ресторанов', 'order' => 4, 'lnk' => '/restaurant-offer'],
            ['menu_name' => 'Главное меню', 'title' => 'Контакты', 'order' => 5, 'lnk' => '/contacts'],

            ['menu_name' => 'Мобильное меню', 'title' => 'О нас', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Каталог', 'order' => 2, 'lnk' => '/catalog'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Оплата и доставка', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Для ресторанов', 'order' => 4, 'lnk' => '/restaurant-offer'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Избранное', 'order' => 5, 'lnk' => '/favorites'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Сравнение', 'order' => 6, 'lnk' => '/compare'],
            ['menu_name' => 'Мобильное меню', 'title' => 'Контакты', 'order' => 7, 'lnk' => '/contacts'],

            ['menu_name' => 'Каталог в подвале', 'title' => 'Наборы', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Разделочные доски', 'order' => 2, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Торцевые изделия', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Интернет-магазин', 'order' => 4, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Индивидуальный заказ', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Наши проекты', 'order' => 2, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'О нас', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Преимущества', 'order' => 4, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Оплата и доставка', 'order' => 5, 'lnk' => '/pages/payment-delivery'],
        ]);
    }
}
