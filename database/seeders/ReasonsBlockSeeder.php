<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ReasonsBlockSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        DB::table('content_blocks')->insert([
            [
                'group' => 'reasons',
                'key' => 'reasons-title',
                'title' => null,
                'value' => 'Несколько причин обратиться к нам',
                'icon' => null,
                'img' => null,
                'order' => 1,
            ],
            [
                'group' => 'reasons',
                'key' => 'reason-1',
                'title' => '10 лет опыта',
                'value' => 'За 10 лет безупречной работы мы реализовали сотни индивидуальных проектов, отточили мастерство и выстроили надёжные цепочки поставок.',
                'icon' => null,
                'img' => null,
                'order' => 2,
            ],
            [
                'group' => 'reasons',
                'key' => 'reason-2',
                'title' => 'Профессиональное оборудование',
                'value' => 'Наше производство оснащено современными высокоточными станками, ЧПУ покрасочными камерами и логистическим терминалом, что обеспечивает непрерывный техпроцесс и высокое качество сервиса для наших клиентов.',
                'icon' => null,
                'img' => null,
                'order' => 3,
            ],
            [
                'group' => 'reasons',
                'key' => 'reason-3',
                'title' => 'Собственная сырьевая база',
                'value' => 'Мы работаем с проверенными поставщиками и располагаем стабильными запасами высококачественной древесины: дуба, бука и ясеня. Это позволяет нам строго контролировать качество изделий на всех этапах.',
                'icon' => null,
                'img' => null,
                'order' => 4,
            ],
            [
                'group' => 'reasons',
                'key' => 'reason-4',
                'title' => 'Внимание к деталям',
                'value' => 'Совершенство состоит из мелочей! От подбора текстуры древесины до финишной шлифовки и тонировки — у нас каждый этап проходит тщательный контроль! Наши мастера учитывают малейшие пожелания заказчика.',
                'icon' => null,
                'img' => null,
                'order' => 5,
            ],
            [
                'group' => 'reasons',
                'key' => 'media-1',
                'title' => null,
                'value' => null,
                'icon' => null,
                'img' => 'reasons/pr_1.webp',
                'order' => 10,
            ],
            [
                'group' => 'reasons',
                'key' => 'media-2',
                'title' => null,
                'value' => null,
                'icon' => null,
                'img' => 'reasons/pr_2.webp',
                'order' => 11,
            ],
            [
                'group' => 'reasons',
                'key' => 'media-3',
                'title' => null,
                'value' => null,
                'icon' => null,
                'img' => 'reasons/pr_3.webp',
                'order' => 12,
            ],
            [
                'group' => 'reasons',
                'key' => 'media-4',
                'title' => null,
                'value' => null,
                'icon' => null,
                'img' => 'reasons/pr_4.webp',
                'order' => 13,
            ],
        ]);
    }

    private function copyAssetsToStorage(): void
    {
        $files = ['pr_1.webp', 'pr_2.webp', 'pr_3.webp', 'pr_4.webp'];

        foreach ($files as $file) {
            $sourcePath = public_path('tmp/reasons/'.$file);
            if (file_exists($sourcePath)) {
                Storage::disk('public')->putFileAs('reasons', new \Illuminate\Http\File($sourcePath), $file);
            }
        }
    }
}
