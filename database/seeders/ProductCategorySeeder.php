<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;  // <-- tambahkan ini
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Aki & Baterai',
                'slug'        => Str::slug('Aki & Baterai'),
                'status'      => 'active',
                'description' => 'Aki mobil dan motor original & aftermarket',
            ],
            [
                'name'        => 'Ban & Velg',
                'slug'        => Str::slug('Ban & Velg'),
                'status'      => 'active',
                'description' => 'Ban mobil, motor, velg racing & standar',
            ],
            [
                'name'        => 'Busi & Pengapian',
                'slug'        => Str::slug('Busi & Pengapian'),
                'status'      => 'active',
                'description' => 'Busi iridium, NGK, Denso, busi standar',
            ],
            [
                'name'        => 'Kampas Rem & Sistem Rem',
                'slug'        => Str::slug('Kampas Rem & Sistem Rem'),
                'status'      => 'active',
                'description' => 'Kampas rem depan/belakang, master rem, selang rem',
            ],
            [
                'name'        => 'Filter & Saringan',
                'slug'        => Str::slug('Filter & Saringan'),
                'status'      => 'active',
                'description' => 'Filter oli, filter udara, filter bensin, filter AC',
            ],
            [
                'name'        => 'Oli & Pelumas',
                'slug'        => Str::slug('Oli & Pelumas'),
                'status'      => 'active',
                'description' => 'Oli mesin, oli transmisi, gemuk, coolant',
            ],
            [
                'name'        => 'Lampu & Kelistrikan',
                'slug'        => Str::slug('Lampu & Kelistrikan'),
                'status'      => 'active',
                'description' => 'Lampu LED, bohlam halogen, relay, kabel',
            ],
            [
                'name'        => 'Suspensi & Shockbreaker',
                'slug'        => Str::slug('Suspensi & Shockbreaker'),
                'status'      => 'active',
                'description' => 'Shock depan/belakang, per daun, bushing',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(  // <-- ubah ke Model:: 
                ['slug' => $category['slug']],  // kondisi pencarian (unique by slug)
                $category                       // data yang di-update atau create
            );
        }
    }
}