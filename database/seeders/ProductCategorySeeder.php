<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;  // <-- tambahkan ini
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Alat Tulis & Perlengkapan Kantor',
                'slug'        => Str::slug('Alat Tulis & Perlengkapan Kantor'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Pulpen, pensil, spidol, kertas, map, stapler, dan perlengkapan kantor lainnya',
            ],
            [
                'name'        => 'Alat Kebersihan',
                'slug'        => Str::slug('Alat Kebersihan'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Sapu, pel, ember, sikat, alat pembersih kaca, dan perlengkapan kebersihan lainnya',
            ],
            [
                'name'        => 'Alat Kesehatan',
                'slug'        => Str::slug('Alat Kesehatan'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Termometer, tensimeter, alat bantu pernapasan, dan perlengkapan kesehatan lainnya',
            ],
            [
                'name'        => 'Home Appliants',
                'slug'        => Str::slug('Home Appliants'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Kulkas, mesin cuci, AC, TV, dan peralatan rumah tangga lainnya',
            ],
            [
                'name'        => 'Furniture',
                'slug'        => Str::slug('Furniture'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Meja, kursi, lemari, rak, dan perabotan rumah tangga lainnya',
            ],
            [
                'name'        => 'IT Hardware & SOftware',
                'slug'        => Str::slug('IT Hardware & Software'),
                'status'      => 'active',
                'image_type' => 'url',
                'image_source' => 'https://res.cloudinary.com/dzcmadjl1/image/upload/v1700000000/product-categories/aki-baterai.jpg',
                'background_color' => '#f0f0f0',
                'description' => 'Laptop, desktop, printer, software, dan perlengkapan IT lainnya',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(  // <-- ubah ke Model:: 
                ['slug' => $category['slug']],  // kondisi pencarian (unique by slug)
                $category                       // data yang di-update atau create
            );
        }
    }
}