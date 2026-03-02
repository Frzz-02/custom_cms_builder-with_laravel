<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik Rumah Tangga',
                'description' => 'Artikel seputar TV, kulkas, mesin cuci, AC, dan perangkat elektronik rumah lainnya.',
            ],
            [
                'name' => 'Komputer & Laptop',
                'description' => 'Tips, review, dan panduan memilih laptop, PC, dan aksesoris komputer.',
            ],
            [
                'name' => 'Tips Perawatan',
                'description' => 'Panduan merawat elektronik dan komputer agar lebih awet dan tahan lama.',
            ],
            [
                'name' => 'Promo & Diskon',
                'description' => 'Informasi promo terbaru untuk produk elektronik dan komputer.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('blog_categories')->insert([
                'status' => 'active',
                'slug' => Str::slug($category['name']),
                'name' => $category['name'],
                'description' => $category['description'],
                'meta_title' => $category['name'] . ' | Toko Elektronik & Komputer',
                'meta_description' => $category['description'],
                'meta_keywords' => strtolower(str_replace(' ', ', ', $category['name'])) . ', elektronik, komputer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}