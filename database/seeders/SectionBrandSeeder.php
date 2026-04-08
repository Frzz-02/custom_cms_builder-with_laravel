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
            
        ];

        DB::table('section_brand')->insert($brands);
    }
}
