<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;

class IndividualBlockSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        DB::table('content_blocks')->insert([
            [
                'group' => 'individual',
                'key' => 'title',
                'title' => null,
                'value' => 'Индивидуальный заказ и именные изделия',
                'icon' => null,
                'img' => null,
                'order' => 1,
            ],
            [
                'group' => 'individual',
                'key' => 'text',
                'title' => null,
                'value' => file_get_contents(public_path('tmp/individual/text.blade.php')),
                'icon' => null,
                'img' => null,
                'order' => 2,
            ],
            [
                'group' => 'individual',
                'key' => 'max_lnk',
                'title' => null,
                'value' => 'https://max.ru/',
                'img' => 'messenger_logo/max_color.svg',
                'icon' => null,
                'order' => 3,
            ],
            [
                'group' => 'individual',
                'key' => 'tg_lnk',
                'title' => null,
                'value' => 'https://t.me/',
                'img' => 'messenger_logo/tg_color.svg',
                'icon' => null,
                'order' => 4,
            ],
            [
                'group' => 'individual',
                'key' => 'slider-1',
                'title' => null,
                'value' => null,
                'img' => 'individual/individual_1.webp',
                'icon' => null,
                'order' => 10,
            ],
            [
                'group' => 'individual',
                'key' => 'slider-2',
                'title' => null,
                'value' => null,
                'img' => 'individual/individual_2.webp',
                'icon' => null,
                'order' => 11,
            ],
        ]);
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'messenger_logo/max_color.svg' => public_path('tmp/messenger_logo/max_color.svg'),
            'messenger_logo/tg_color.svg' => public_path('tmp/messenger_logo/tg_color.svg'),
            'individual/individual_1.webp' => public_path('tmp/individual/individual_1.webp'),
            'individual/individual_2.webp' => public_path('tmp/individual/individual_2.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                $dir = dirname($path);
                Storage::disk('public')->makeDirectory($dir);
                Storage::disk('public')->putFileAs($dir, new \Illuminate\Http\File($source), basename($path));
            }
        }
    }
}
