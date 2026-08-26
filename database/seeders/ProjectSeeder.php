<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        $projects = [
            [
                'title' => 'Кабинет руководителя',
                'description' => null,
                'img' => 'projects/proj_1.webp',
                'gallery' => null,
            ],
            [
                'title' => 'Окна для проекта мужская гимназия г. Курск',
                'description' => null,
                'img' => 'projects/proj_2.webp',
                'gallery' => null,
            ],
            [
                'title' => 'Деревянное зодчество',
                'description' => null,
                'img' => 'projects/proj_3.webp',
                'gallery' => null,
            ],
        ];

        foreach ($projects as $data) {
            Project::create($data);
        }
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'projects/proj_1.webp' => public_path('tmp/projects/proj_1.webp'),
            'projects/proj_2.webp' => public_path('tmp/projects/proj_2.webp'),
            'projects/proj_3.webp' => public_path('tmp/projects/proj_3.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                Storage::disk('public')->putFileAs(dirname($path), new \Illuminate\Http\File($source), basename($path));
            }
        }
    }
}
