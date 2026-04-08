<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Page::create([
            'slug' => null,
            'status' => 'published',
            'title' => 'Home',
            'template' => 'homepage',
            'header_style' => 'header style 1',
            'meta_title' => 'Home - Mitraoke',
            'meta_description' => 'Welcome to Mitraoke, your trusted partner for karaoke machine rentals in Indonesia. We offer a wide range of high-quality karaoke machines for all occasions.',
            'meta_keywords' => 'karaoke machine rental, Mitraoke, karaoke Indonesia, event entertainment, party rental',
        ]);      
        
    }
}
