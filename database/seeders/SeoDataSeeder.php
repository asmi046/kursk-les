<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SeoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'url' => '/',
                'seo_title' => 'Изделия из твердых пород дерева в Курске',
                'seo_description' => 'Изготовление изделий из твердых пород дерева в Курске. Широкий ассортимент продукции, высокое качество и индивидуальный подход к каждому клиенту.',
                'page_title' => '',
                // 'seoable_id' => 1,
                // 'seoable_type' => "App\Models\Page"
            ],
            [
                'url' => 'page/politika-v-oblasti-obrabotki-personalnyx-dannyx',
                'seo_title' => 'Политика в области обработки персональных данных',
                'seo_description' => 'Политика в области обработки персональных данных',
                'page_title' => '',
                // 'seoable_id' => 1,
                // 'seoable_type' => "App\Models\Page"
            ],
            [
                'url' => 'page/soglasie-na-obrabotku-personalnyx-dannyx',
                'seo_title' => 'Согласие на обработку персональных данных',
                'seo_description' => 'Согласие на обработку персональных данных',
                'page_title' => '',
                // 'seoable_id' => 1,
                // 'seoable_type' => "App\Models\Page"
            ],
            [
                'url' => 'page/o-failax-cookie',
                'seo_title' => 'Подробнее о файлах cookie',
                'seo_description' => 'Подробнее о файлах cookie',
                'page_title' => '',
                // 'seoable_id' => 1,
                // 'seoable_type' => "App\Models\Page"
            ],
        ];

        DB::table('seo_data')->insert($data);
    }
}
