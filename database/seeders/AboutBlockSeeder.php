<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class AboutBlockSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('content_blocks')->insert([
            [
                'group' => 'about',
                'key' => 'about-title',
                'title' => null,
                'value' => 'О нас',
                'icon' => null,
                'img' => null,
                'order' => 1,
            ],
            [
                'group' => 'about',
                'key' => 'about-text',
                'title' => null,
                'value' => file_get_contents(public_path('tmp/about/text.blade.php')),
                'icon' => null,
                'img' => null,
                'order' => 2,
            ],
        ]);
    }
}
