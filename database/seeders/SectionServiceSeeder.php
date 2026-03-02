<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SectionServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('section_service')->insert([
            
            // 1️⃣ Garansi Produk
            [
                'name' => 'Garansi Resmi 100%',
                'slug' => 'garansi-resmi-100',
                'status' => 'active',
                'content' => 'Semua produk elektronik dan komputer yang kami jual dilengkapi garansi resmi. Jika terjadi kerusakan atau cacat produksi, kami siap membantu proses klaim dengan cepat dan mudah.',
                'image' => 'services/garansi.jpg',
                'image_featured' => 'services/garansi-featured.jpg',
                'is_featured' => 1,
                'meta_title' => 'Garansi Resmi Produk Elektronik & Komputer',
                'meta_description' => 'Dapatkan garansi resmi untuk semua produk elektronik rumah tangga dan komputer.',
                'meta_keyword' => 'garansi elektronik, garansi komputer, toko elektronik terpercaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2️⃣ Produk Original & Berkualitas
            [
                'name' => 'Produk Original & Berkualitas',
                'slug' => 'produk-original-berkualitas',
                'status' => 'active',
                'content' => 'Kami hanya menyediakan produk original dari brand terpercaya seperti TV, kulkas, mesin cuci, laptop, printer, dan aksesoris komputer dengan kualitas terbaik.',
                'image' => 'services/produk-original.jpg',
                'image_featured' => 'services/produk-original-featured.jpg',
                'is_featured' => 1,
                'meta_title' => 'Produk Elektronik & Komputer Original',
                'meta_description' => 'Belanja elektronik rumah tangga dan komputer original dengan kualitas terbaik.',
                'meta_keyword' => 'elektronik original, laptop original, komputer original',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3️⃣ Pengiriman Cepat & Aman
            [
                'name' => 'Pengiriman Cepat & Aman',
                'slug' => 'pengiriman-cepat-aman',
                'status' => 'active',
                'content' => 'Pesanan Anda akan diproses dengan cepat dan dikirim dengan packing aman untuk memastikan produk sampai tanpa kerusakan.',
                'image' => 'services/pengiriman.jpg',
                'image_featured' => 'services/pengiriman-featured.jpg',
                'is_featured' => 0,
                'meta_title' => 'Pengiriman Cepat Elektronik & Komputer',
                'meta_description' => 'Layanan pengiriman cepat dan aman untuk semua produk elektronik dan komputer.',
                'meta_keyword' => 'pengiriman elektronik, kirim laptop aman, toko komputer online',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
