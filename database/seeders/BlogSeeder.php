<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Tips Memilih Laptop Terbaik untuk Kerja',
                'content' => 'Memilih laptop untuk kerja membutuhkan pertimbangan spesifikasi seperti RAM, prosesor, dan storage...',
                'author' => 'Admin',
                'category_id' => 2
            ],
            [
                'title' => 'Cara Merawat Mesin Cuci Agar Awet',
                'content' => 'Mesin cuci perlu perawatan rutin seperti membersihkan filter dan tidak melebihi kapasitas...',
                'author' => 'Admin',
                'category_id' => 1
            ],
            [
                'title' => 'Promo Elektronik Terbaru Bulan Ini',
                'content' => 'Dapatkan promo spesial untuk TV, AC, dan kulkas dengan harga terbaik...',
                'author' => 'Marketing Team',
                'category_id' => 4
            ],
        ];

        foreach ($blogs as $blog) {
            DB::table('blogs')->insert([
                'is_featured' => '1',
                'status' => 'published',
                'publish_date' => now(),
                'blog_categories_id' => $blog['category_id'],
                'image_featured' => 'featured.jpg',
                'author' => $blog['author'],
                'slug' => Str::slug($blog['title']),
                'name' => $blog['title'],
                'title' => $blog['title'],
                'content' => $blog['content'],
                'image' => 'blog.jpg',
                'meta_title' => $blog['title'] . ' | Blog Elektronik',
                'meta_description' => substr($blog['content'], 0, 150),
                'meta_keywords' => 'blog, elektronik, laptop, promo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}