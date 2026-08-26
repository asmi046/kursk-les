<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use App\Models\Certificate;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $this->copyAssetsToStorage();

        $certificates = [
            ['img' => 'certificates/cert_1.webp', 'order' => 1],
            ['img' => 'certificates/cert_2.webp', 'order' => 2],
            ['img' => 'certificates/cert_1.webp', 'order' => 3],
            ['img' => 'certificates/cert_2.webp', 'order' => 4],
            ['img' => 'certificates/cert_1.webp', 'order' => 5],
            ['img' => 'certificates/cert_2.webp', 'order' => 6],
            ['img' => 'certificates/cert_1.webp', 'order' => 7],
            ['img' => 'certificates/cert_2.webp', 'order' => 8],
        ];

        foreach ($certificates as $data) {
            Certificate::create($data);
        }
    }

    private function copyAssetsToStorage(): void
    {
        $files = [
            'certificates/cert_1.webp' => public_path('img/certificates/cert_1.webp'),
            'certificates/cert_2.webp' => public_path('img/certificates/cert_2.webp'),
        ];

        foreach ($files as $path => $source) {
            if (file_exists($source)) {
                Storage::disk('public')->putFileAs(dirname($path), new \Illuminate\Http\File($source), basename($path));
            }
        }
    }
}
