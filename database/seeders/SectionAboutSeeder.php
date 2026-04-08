<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SectionAboutSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        DB::table('section_about')->insert([
            // Section Header
            'section_label' => 'TENTANG MITRA COM',
            'section_title' => 'Dedikasi untuk Kemandirian Industri Dalam Negeri',
            'section_description' => 'Mitra Com adalah mitra strategis penyedia barang yang berfokus pada produk berkualitas tinggi dengan sertifikasi Tingkat Komponen Dalam Negeri (TKDN). Kami hadir sebagai solusi pengadaan yang transparan, akuntabel, dan terpercaya untuk mendukung program pemerintah dalam penguatan industri nasional.',
            
            // Images - Menggunakan placeholder yang relevan dengan office/professional procurement
            'image_1_type' => 'url',
            'image_1_source' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
            'image_1_alt' => 'Professional Office Environment',
            
            'image_2_type' => 'url',
            'image_2_source' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&q=80',
            'image_2_alt' => 'Business Handshake Professional',
            
            'image_3_type' => 'url',
            'image_3_source' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&q=80',
            'image_3_alt' => 'Procurement Strategy Meeting',
            
            // Benefits
            'benefit_title' => 'Kenapa memilih layanan Mitra Com?',
            
            // Column 1
            'benefit_1_text' => 'Sertifikasi Resmi TKDN',
            'benefit_1_icon' => 'check-circle',
            'benefit_1_enabled' => true,
            
            'benefit_2_text' => 'Terdaftar di e-Katalog LKPP',
            'benefit_2_icon' => 'check-circle',
            'benefit_2_enabled' => true,
            
            'benefit_3_text' => 'Proses Pengadaan Aman & Transparan',
            'benefit_3_icon' => 'check-circle',
            'benefit_3_enabled' => true,
            
            // Column 2
            'benefit_4_text' => 'Dukungan Pendampingan Penuh',
            'benefit_4_icon' => 'check-circle',
            'benefit_4_enabled' => true,
            
            'benefit_5_text' => 'Kepatuhan Terhadap Regulasi',
            'benefit_5_icon' => 'check-circle',
            'benefit_5_enabled' => true,
            
            'benefit_6_text' => 'Produk Bergaransi Resmi',
            'benefit_6_icon' => 'check-circle',
            'benefit_6_enabled' => true,
            
            // Styling (disesuaikan dengan nuansa profesional/corporate)
            'section_background' => 'white',
            'label_color' => 'blue-700',
            'title_color' => 'slate-900',
            'description_color' => 'slate-600',
            'benefit_icon_color' => 'orange-600', // Sesuai dengan aksen tombol di gambar
            
            // Meta
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}