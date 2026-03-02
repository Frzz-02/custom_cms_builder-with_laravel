<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionCompleteCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            [
                'title'  => 'Pengiriman Cepat',
                'icon'   => 'icon-feather-clock', // Menyesuaikan icon jam di gambar
                'amount' => null,
                'status' => 'active',
            ],
            [
                'title'  => 'Gratis Ongkir*',
                'icon'   => 'icon-feather-map-pin', // Menyesuaikan icon pin di gambar
                'amount' => null,
                'status' => 'active',
            ],
            [
                'title'  => 'Klien Puas',
                'icon'   => 'icon-feather-users', // Menyesuaikan icon grup orang
                'amount' => 1250, // Mengambil angka dari "1250+ Klien Puas"
                'status' => 'active',
            ],
            [
                'title'  => 'Garansi Resmi',
                'icon'   => 'icon-feather-shield', // Menyesuaikan icon perisai
                'amount' => null,
                'status' => 'active',
            ],
            [
                'title'  => 'Produk Original',
                'icon'   => 'icon-feather-box', // Menyesuaikan icon kubus/paket
                'amount' => null,
                'status' => 'active',
            ],
            [
                'title'  => 'Harga Kompetitif',
                'icon'   => 'icon-feather-dollar-sign', // Menyesuaikan icon dollar
                'amount' => null,
                'status' => 'active',
            ],
        ];

        foreach ($benefits as $benefit) {
            DB::table('section_completecount')->insert(array_merge($benefit, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
