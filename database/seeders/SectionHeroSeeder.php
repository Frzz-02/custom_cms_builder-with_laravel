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
            'title' => 'Spare Part Kendaraan Original & Berkualitas',
            'title_2' => 'Solusi Terbaik Untuk Mobil & Motor Anda',
            'title_3' => 'Harga Terjangkau, Kualitas Terjamin',
            'title_4' => 'Harga Terjangkau, Kualitas Terjamin',
            'title_5' => 'Harga Terjangkau, Kualitas Terjamin',
            'title_6' => 'Harga Terjangkau, Kualitas Terjamin',

            'description' => 'Kami menyediakan berbagai spare part kendaraan original dan aftermarket berkualitas tinggi untuk semua jenis mobil dan motor.',
            'description_2' => 'Mulai dari oli, filter, kampas rem, aki, shockbreaker, hingga komponen mesin lengkap tersedia di toko kami.',
            'description_3' => 'Dapatkan harga terbaik dengan pelayanan profesional dan pengiriman cepat langsung ke lokasi Anda.',
            'description_4' => 'Dapatkan harga terbaik dengan pelayanan profesional dan pengiriman cepat langsung ke lokasi Anda.',
            'description_5' => 'Dapatkan harga terbaik dengan pelayanan profesional dan pengiriman cepat langsung ke lokasi Anda.',
            'description_6' => 'Dapatkan harga terbaik dengan pelayanan profesional dan pengiriman cepat langsung ke lokasi Anda.',

            // Images (contoh path)
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

            'image_background' => 'hero/bg-otomotif.jpg',
            'image_background_2' => 'hero/bg-garasi.jpg',
            'image_background_3' => 'hero/bg-bengkel.jpg',

            'action_label' => 'Belanja Sekarang',
            'action_label_2' => 'Lihat Katalog',
            'action_label_3' => 'Hubungi Kami',
            'action_label_4' => 'Hubungi Kami',
            'action_label_5' => 'Hubungi Kami',
            'action_label_6' => 'Hubungi Kami',
            
            'action_url' => '/',
            'action_url_2' => '/',
            'action_url_3' => '/',
            'action_url_4' => '/',
            'action_url_5' => '/',
            'action_url_6' => '/',

            'video_url' => null,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}