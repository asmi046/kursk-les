<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SeoData;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Кабинет руководителя',
                'slug' => 'kabinet-rukovoditelya',
                'img' => 'projects/proj_1.webp',
                'tmp_img' => 'proj_1.webp',
                'gallery_dir' => 'kabinet_rukovoditela',
                'description_file' => 'proj_1.html',
            ],
            [
                'title' => 'Окна для проекта мужская гимназия г. Курск',
                'slug' => 'okna-muzhskaya-gimnaziya-kursk',
                'img' => 'projects/proj_2.webp',
                'tmp_img' => 'proj_2.webp',
                'gallery_dir' => 'okna_dveri_restovratsia',
                'description_file' => 'proj_2.html',
            ],
            [
                'title' => 'Деревянное зодчество',
                'slug' => 'derevyannoe-zodchestvo',
                'img' => 'projects/proj_3.webp',
                'tmp_img' => 'proj_3.webp',
                'gallery_dir' => 'zodchestvo',
                'description_file' => 'proj_3.html',
            ],
            [
                'title' => 'Мебель для магазина',
                'slug' => 'mebel-dlya-magazina',
                'img' => 'projects/magazin/IMG_5392.webp',
                'tmp_img' => null,
                'gallery_dir' => 'magazin',
                'description_file' => 'magazin.html',
            ],
            [
                'title' => 'ТРЦ "Боше" г. Старый Оскол',
                'slug' => 'trc-boshe-staryy-oskol',
                'img' => 'projects/trc_oskol/DSC_1701.webp',
                'tmp_img' => null,
                'gallery_dir' => 'trc_oskol',
                'description_file' => 'trc_oskol.html',
            ],
        ];

        SeoData::firstOrCreate(
            ['url' => 'projects'],
            [
                'seo_title' => 'Наши проекты',
                'seo_description' => 'Реализованные проекты компании «КурскЛес» — изделия из твердых пород дерева для дома, офиса и общественных пространств.',
                'page_title' => '',
            ]
        );

        foreach ($projects as $data) {
            $gallery = $this->copyGallery($data['gallery_dir'], $data['title']);

            $img = $data['img'];
            if ($img === null) {
                $img = $gallery[0]['img'];
            } elseif ($data['tmp_img'] !== null && file_exists(public_path('tmp/projects/'.$data['tmp_img']))) {
                Storage::disk('public')->putFileAs('projects', new File(public_path('tmp/projects/'.$data['tmp_img'])), $data['tmp_img']);
            }

            $project = Project::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => file_get_contents(public_path('tmp/projects/'.$data['description_file'])),
                'img' => $img,
                'gallery' => $gallery,
            ]);

            SeoData::firstOrCreate(
                ['url' => 'projects/'.$project->slug],
                [
                    'seo_title' => $project->title,
                    'seo_description' => $project->title.' — реализованный проект компании «КурскЛес».',
                    'page_title' => '',
                ]
            );
        }
    }

    /**
     * Копирует изображения галереи из public/tmp/projects/{dir} в storage
     * и возвращает массив для поля gallery: ссылка на изображение и alt.
     *
     * @return array<int, array{img: string, alt: string}>
     */
    private function copyGallery(string $dir, string $title): array
    {
        $result = [];
        $files = glob(public_path('tmp/projects/'.$dir).'/*.webp') ?: [];

        sort($files);

        foreach ($files as $file) {
            $name = basename($file);
            Storage::disk('public')->putFileAs('projects/'.$dir, new File($file), $name);

            $result[] = [
                'img' => 'projects/'.$dir.'/'.$name,
                'alt' => $title.' — фото '.$name,
            ];
        }

        return $result;
    }
}
