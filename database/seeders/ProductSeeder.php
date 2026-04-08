<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori dari database (asumsi sudah di-seed dulu)
        $categories = DB::table('product_categories')->pluck('id', 'slug');

        // 2. Data Produk (Contoh Barang yang biasanya ada di e-Katalog/TKDN)
        $products = [
            // IT Hardware
            [
                'products_code'       => 'LAPTOP-TKDN-01',
                'title'                => 'Laptop LocalBrand X1 - TKDN 40%',
                'slug'                 => Str::slug('Laptop LocalBrand X1 - TKDN 40%'),
                'product_categories_id' => $categories['it-hardware-software'],
                'overview'            => 'Laptop performa tinggi dengan kandungan lokal (TKDN) memenuhi syarat pengadaan.',
                'content'             => 'Core i5 Gen 12, RAM 16GB, SSD 512GB, Windows 11 Pro Original.',
                'price'                => 12500000,
                'sale_price'          => 11900000,
                'stock'                => 50,
                'show_price'          => true,
                'is_featured'          => 'yes',
                'status'              => 'active',
                'image'                => 'laptop-tkdn.jpg',
                'image_title'          => 'Laptop TKDN Mitra Com',
                'meta_title'          => 'Jual Laptop TKDN Murah untuk Pengadaan Instansi',
                'meta_description'    => 'Laptop lokal berkualitas dengan sertifikasi TKDN 40%. Ready stock untuk e-katalog.',
                'meta_keywords'       => 'laptop tkdn, pengadaan laptop, lkpp laptop, mitra com',
            ],

            // Furniture
            [
                'products_code'       => 'CHAIR-OFF-02',
                'title'                => 'Kursi Kantor Ergonomis Mesh Series',
                'slug'                 => Str::slug('Kursi Kantor Ergonomis Mesh Series'),
                'product_categories_id' => $categories['furniture'],
                'overview'            => 'Kursi kerja standar perkantoran modern dengan fitur tilting control.',
                'content'             => 'Bahan mesh berkualitas, hydraulic system, garansi rangka 2 tahun.',
                'price'                => 1850000,
                'sale_price'          => null,
                'stock'                => 100,
                'show_price'          => true,
                'is_featured'          => 'yes',
                'status'              => 'active',
                'image'                => 'kursi-kantor.jpg',
                'image_title'          => 'Kursi Ergonomis Mitra Com',
                'meta_title'          => 'Kursi Kantor Ergonomis Standar Pengadaan LKPP',
                'meta_description'    => 'Sedia kursi kantor berkualitas untuk instansi pemerintah dan swasta.',
                'meta_keywords'       => 'kursi kantor, furniture tkdn, pengadaan kursi, mitra com',
            ],

            // ATK
            [
                'products_code'       => 'PAPER-A4-03',
                'title'                => 'Kertas HVS A4 80gr High Quality',
                'slug'                 => Str::slug('Kertas HVS A4 80gr High Quality'),
                'product_categories_id' => $categories['alat-tulis-perlengkapan-kantor'],
                'overview'            => 'Kertas photocopy premium untuk kebutuhan administrasi harian.',
                'content'             => 'Ukuran A4, 80 gram, 1 box isi 5 rim, warna putih cerah.',
                'price'                => 275000,
                'sale_price'          => 265000,
                'stock'                => 500,
                'show_price'          => true,
                'is_featured'          => 'no',
                'status'              => 'active',
                'image'                => 'kertas-hvs.jpg',
                'image_title'          => 'Kertas HVS A4 80gr',
                'meta_title'          => 'Grosir Kertas HVS A4 untuk Instansi',
                'meta_description'    => 'Penyedia ATK lengkap dan kertas HVS untuk kebutuhan kantor pemerintah.',
                'meta_keywords'       => 'atk murah, kertas hvs a4, supplier atk jakarta, mitra com',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['products_code' => $product['products_code']],
                $product + [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}