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
            'meta_title' => 'Solusi Pengadaan Barang TKDN & e-Katalog LKPP - Mitra Com',
            'meta_description' => 'Mitra Com menyediakan jasa pengadaan barang tersertifikasi TKDN yang transparan dan akuntabel. Terdaftar di e-Katalog LKPP untuk instansi Anda. Konsultasi gratis!',
            'meta_keywords' => 'pengadaan barang TKDN, e-katalog LKPP, Mitra Com, pengadaan instansi pemerintah, produk dalam negeri, INAPROC',
        ]);  
        
    }
}
