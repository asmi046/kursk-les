<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class AdvantagesBlockSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('content_blocks')->insert([
            [
                'group' => 'advantages',
                'key' => 'adv-natural',
                'title' => 'Натуральные<br>материалы',
                'value' => 'Для производства наших разделочных и сервировочных досок мы используем только экологически чистые материалы безопасные для человека.',
                'icon' => '#icon-adv-natural',
                'img' => null,
                'order' => 1,
            ],
            [
                'group' => 'advantages',
                'key' => 'adv-exclusiv',
                'title' => 'Эксклюзивный<br>дизайн',
                'value' => 'Каждое изделие в нашем интернет магазине это произведение столярного искусства за которым стоит кропотливая работа мастера.',
                'icon' => '#icon-adv-exclusiv',
                'img' => null,
                'order' => 2,
            ],
            [
                'group' => 'advantages',
                'key' => 'adv-dolgov',
                'title' => 'Долговечность<br>изделий',
                'value' => 'Благодаря качеству исполнения, качеств сырья и материалов наши изделия будут радовать Вас долгие годы. Сделайте подарок себе и близким!',
                'icon' => '#icon-adv-dolgov',
                'img' => null,
                'order' => 3,
            ],
        ]);
    }
}
