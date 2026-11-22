<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SeoData;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Простые текстовые страницы интернет-магазина.
     */
    private const PAGES = [
        [
            'title' => 'Политика в области обработки персональных данных',
            'slug' => 'personal-data-policy',
            'file' => 'personal-data-policy.html',
        ],
        [
            'title' => 'Согласие на обработку персональных данных',
            'slug' => 'personal-data-consent',
            'file' => 'personal-data-consent.html',
        ],
        [
            'title' => 'О файлах cookie',
            'slug' => 'cookie',
            'file' => 'cookie.html',
        ],
    ];

    public function run(): void
    {
        foreach (self::PAGES as $data) {
            $page = Page::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => file_get_contents(public_path('tmp/pages/'.$data['file'])),
                ]
            );

            SeoData::firstOrCreate(
                ['url' => 'pages/'.$page->slug],
                [
                    'seo_title' => $page->title,
                    'seo_description' => $page->title.' — интернет-магазин «КурскЛес».',
                    'page_title' => '',
                ]
            );
        }
    }
}
