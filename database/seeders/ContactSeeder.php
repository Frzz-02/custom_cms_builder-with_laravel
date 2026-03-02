<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use App\Models\Contacts; // Pastikan nama model sesuai (Contacts atau Contact)



class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title'      => 'Lokasi Galeri Elektronik',
                'contact_1'  => 'Jl. Tekno Utama No. 45, Kawasan Niaga, Kendal.',
                'contact_2'  => 'Jawa Tengah, Indonesia',
                'contact_3'  => null,
                'icon'       => 'icon-feather-map-pin',
                'background' => 'icon-gradient-1',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Customer Service & Sales',
                'contact_1'  => '+62 822-1020-0700',
                'contact_2'  => 'sales@tokoelektronik.com',
                'contact_3'  => null,
                'icon'       => 'icon-feather-phone',
                'background' => 'icon-gradient-2',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Layanan Teknis & Garansi',
                'contact_1'  => '+62 812-3456-7890',
                'contact_2'  => 'Tersedia Sparepart Komputer & Laptop',
                'contact_3'  => null,
                'icon'       => 'icon-feather-settings',
                'background' => 'icon-gradient-4',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Jam Operasional Toko',
                'contact_1'  => 'Senin – Sabtu: 08.00 – 21.00 WIB',
                'contact_2'  => 'Minggu & Hari Libur: 10.00 – 17.00 WIB',
                'contact_3'  => null,
                'icon'       => 'icon-feather-calendar',
                'background' => 'icon-gradient-3',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            Contact::create($item);
        }
    }
}