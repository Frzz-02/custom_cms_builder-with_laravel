<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SectionBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $brands = [
            [
                'name' => 'Microsoft Pilots',
                'logo' => null,
                'url' => 'https://www.microsoft.com',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Zurich',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Zurich_Insurance_Group_Logo_Horizontal.svg/1280px-Zurich_Insurance_Group_Logo_Horizontal.svg.png?20210708180852',
                'url' => 'https://www.zurich.com',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Yili',
                'logo' => null,
                'url' => '#',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sampoerna Strategic',
                'logo' => null,
                'url' => '#',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'PT.Karya Putra Borneo',
                'logo' => null,
                'url' => '#',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bank Neo',
                'logo' => null,
                'url' => 'https://www.bankneocommerce.co.id',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mitsubishi Motors',
                'logo' => null,
                'url' => 'https://www.mitsubishi-motors.com',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Partai Nasdem',
                'logo' => null,
                'url' => '#',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('section_brand')->insert($brands);
    }
}
