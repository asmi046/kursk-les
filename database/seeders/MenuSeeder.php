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
            ['menu_name' => 'Главное меню', 'title' => 'Категории', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'Магазин', 'order' => 2, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'Индивидуальный заказ', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'Проекты', 'order' => 4, 'lnk' => '#'],
            ['menu_name' => 'Главное меню', 'title' => 'О нас', 'order' => 5, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Наборы', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Разделочные доски', 'order' => 2, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Торцевые изделия', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Каталог в подвале', 'title' => 'Интернет-магазин', 'order' => 4, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Индивидуальный заказ', 'order' => 1, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Наши проекты', 'order' => 2, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'О нас', 'order' => 3, 'lnk' => '#'],
            ['menu_name' => 'Информация в подвале', 'title' => 'Преимущества', 'order' => 4, 'lnk' => '#'],
        ]);
    }
}
