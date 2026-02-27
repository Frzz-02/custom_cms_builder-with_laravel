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

        $products = [
            // Aki
            [
                'products_code'       => 'AKI001',
                'title'               => 'Aki Mobil GS Astra 55D23L',
                'slug'                => Str::slug('Aki Mobil GS Astra 55D23L'),
                'product_categories_id' => $categories['aki-baterai'] ?? 1,
                'overview'            => 'Aki basah berkualitas tinggi untuk mobil Jepang',
                'content'             => 'Kapasitas 60Ah, garansi 12 bulan, tahan getar.',
                'price'               => 950000,
                'sale_price'          => 899000,
                'stock'               => 45,
                'is_featured'         => 'yes',
                'status'              => 'active',
                'image'               => 'aki-gs-astra.jpg',
                'image_title'         => 'Aki GS Astra 55D23L',
                'meta_title'          => 'Aki Mobil GS Astra 55D23L Murah Yogyakarta',
                'meta_description'    => 'Jual aki mobil GS Astra original dengan harga terbaik.',
                'meta_keywords'       => 'aki mobil, aki astra, sparepart aki, aki yogyakarta',
            ],

            // Ban
            [
                'products_code'       => 'BAN001',
                'title'               => 'Ban Mobil Bridgestone Turanza T005 205/55 R16',
                'slug'                => Str::slug('Ban Mobil Bridgestone Turanza T005 205/55 R16'),
                'product_categories_id' => $categories['ban-velg'] ?? 2,
                'overview'            => 'Ban touring premium untuk kenyamanan & grip maksimal',
                'content'             => 'Ukuran 205/55 R16, compound silica, anti aquaplaning.',
                'price'               => 1250000,
                'sale_price'          => null,
                'stock'               => 32,
                'is_featured'         => 'yes',
                'status'              => 'active',
                'image'               => 'ban-bridgestone-turanza.jpg',
                'image_title'         => 'Ban Bridgestone Turanza T005',
                'meta_title'          => 'Ban Mobil Bridgestone Turanza Murah',
                'meta_description'    => 'Ban Bridgestone original ukuran 205/55 R16 ready stock.',
                'meta_keywords'       => 'ban mobil, bridgestone, ban turanza, sparepart ban',
            ],

            // Busi
            [
                'products_code'       => 'BUSI001',
                'title'               => 'Busi NGK Iridium IX Honda Beat Vario',
                'slug'                => Str::slug('Busi NGK Iridium IX Honda Beat Vario'),
                'product_categories_id' => $categories['busi-pengapian'] ?? 3,
                'overview'            => 'Busi iridium tahan lama & performa tinggi',
                'content'             => 'NGK CR7HIX, umur pakai hingga 40.000 km.',
                'price'               => 65000,
                'sale_price'          => 55000,
                'stock'               => 120,
                'is_featured'         => 'yes',
                'status'              => 'active',
                'image'               => 'busi-ngk-iridium.jpg',
                'image_title'         => 'Busi NGK Iridium Beat Vario',
                'meta_title'          => 'Busi NGK Iridium untuk Motor Honda',
                'meta_description'    => 'Busi NGK original untuk Beat, Vario, Scoopy.',
                'meta_keywords'       => 'busi ngk, busi iridium, sparepart motor honda',
            ],

            // Kampas Rem
            [
                'products_code'       => 'REM001',
                'title'               => 'Kampas Rem Depan Honda Vario 125/150 Original',
                'slug'                => Str::slug('Kampas Rem Depan Honda Vario 125/150 Original'),
                'product_categories_id' => $categories['kampas-rem-sistem-rem'] ?? 4,
                'overview'            => 'Kampas rem OEM Honda asli pabrik',
                'content'             => 'Kualitas standar pabrikan, minim debu, tahan lama.',
                'price'               => 85000,
                'sale_price'          => null,
                'stock'               => 85,
                'is_featured'         => 'no',
                'status'              => 'active',
                'image'               => 'kampas-rem-vario.jpg',
                'image_title'         => 'Kampas Rem Depan Vario',
                'meta_title'          => 'Kampas Rem Honda Vario Original',
                'meta_description'    => 'Kampas rem depan original Honda Vario 125/150.',
                'meta_keywords'       => 'kampas rem vario, sparepart honda, kampas rem motor',
            ],

            // Filter Udara
            [
                'products_code'       => 'FILTER001',
                'title'               => 'Filter Udara Knalpot Racing Toyota Avanza Veloz',
                'slug'                => Str::slug('Filter Udara Knalpot Racing Toyota Avanza Veloz'),
                'product_categories_id' => $categories['filter-saringan'] ?? 5,
                'overview'            => 'Filter udara aftermarket untuk performa lebih baik',
                'content'             => 'Bahan kertas premium, aliran udara optimal.',
                'price'               => 120000,
                'sale_price'          => 105000,
                'stock'               => 60,
                'is_featured'         => 'no',
                'status'              => 'active',
                'image'               => 'filter-udara-avanza.jpg',
                'image_title'         => 'Filter Udara Avanza Racing',
                'meta_title'          => 'Filter Udara Toyota Avanza Veloz',
                'meta_description'    => 'Filter udara racing untuk Avanza, Veloz, Sigra.',
                'meta_keywords'       => 'filter udara avanza, sparepart toyota, filter racing',
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