<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SectionHero;
use Illuminate\Support\Facades\DB;

class SectionHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('section_hero')->insert([
            // Titles (Mengambil headline utama dari gambar 1)
            'title' => 'Solusi Pengadaan Barang TKDN Terpercaya untuk Negeri',
            'title_2' => 'Mitra Strategis Pengadaan Barang Pemerintah & Instansi',
            'title_3' => 'Produk Berkualitas dengan Sertifikasi Resmi TKDN',
            'title_4' => 'Proses Pengadaan Transparan, Aman, dan Profesional',
            'title_5' => 'Dukung Kemandirian Industri Dalam Negeri Bersama Kami',
            'title_6' => 'Tersedia Lengkap di e-Katalog LKPP & INAPROC',

            // Descriptions (Penjelasan lebih detail dari gambar 1 & 2)
            'description' => 'Mitra Com menghadirkan produk berkualitas dengan sertifikasi TKDN dan garansi resmi untuk mendukung kebutuhan instansi Anda.',
            'description_2' => 'Kami memahami bahwa dalam dunia pengadaan, kepatuhan terhadap regulasi dan kualitas produk adalah prioritas utama bagi operasional bisnis Anda.',
            'description_3' => 'Tim kami siap mendampingi setiap langkah proses pengadaan, mulai dari konsultasi hingga barang sampai di lokasi dengan aman.',
            'description_4' => 'Pastikan efisiensi anggaran instansi Anda dengan memilih vendor yang terdaftar resmi di e-Katalog LKPP dan INAPROC.',
            'description_5' => 'Mendukung program penguatan industri nasional melalui penyediaan produk dalam negeri dengan standar teknis yang ketat.',
            'description_6' => 'Keamanan dan ketenangan pikiran Anda adalah fokus kami melalui layanan purna jual dan garansi resmi di setiap produk.',

            // Images (Menggunakan placeholder yang relevan dengan procurement & business)
            'image' => 'hero/sparepart-main.jpg',
            'image_2' => 'hero/oli.jpg',
            'image_3' => 'hero/kampas-rem.jpg',
            'image_4' => null,
            'image_5' => null,
            'image_6' => null,
            'image_7' => null,
            'image_8' => null,
            'image_9' => null,
            'image_10' => null,
            'image_11' => null,
            'image_12' => null,
            'image_13' => null,
            'image_14' => null,

            // Backgrounds (Nuansa gedung kantor atau teknologi sesuai gambar 2)
            'image_background' => 'hero/bg-otomotif.jpg',
            'image_background_2' => 'hero/bg-garasi.jpg',
            'image_background_3' => 'hero/bg-bengkel.jpg',

            // Action Labels (CTA yang lebih cocok untuk B2B/Pemerintah)
            'action_label' => 'Konsultasi Gratis',
            'action_label_2' => 'Lihat e-Katalog',
            'action_label_3' => 'Hubungi Kami',
            'action_label_4' => 'Pelajari TKDN',
            'action_label_5' => 'Daftar Produk',
            'action_label_6' => 'Tentang Kami',
            
            'action_url' => '/contact',
            'action_url_2' => '/katalog',
            'action_url_3' => '/contact',
            'action_url_4' => '/about-tkdn',
            'action_url_5' => '/products',
            'action_url_6' => '/about',

            'video_url' => null,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}