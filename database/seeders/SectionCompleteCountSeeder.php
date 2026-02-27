<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionCompleteCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'          => 2,
                'title'       => 'Klien',
                'icon'        => 'far fa-plus',
                'amount'      => 1980,          // dari tampilan: 1.980 → tanpa titik
                'status'      => 'active',
                'created_at'  => Carbon::parse('2024-12-24 03:26:19'),
                'updated_at'  => Carbon::parse('2025-05-09 14:06:06'),
            ],
            [
                'id'          => 3,
                'title'       => 'Lembaga',
                'icon'        => 'far fa-plus',
                'amount'      => 876,
                'status'      => 'active',
                'created_at'  => Carbon::parse('2024-12-24 03:26:37'),
                'updated_at'  => Carbon::parse('2025-05-09 14:04:46'),
            ],
            [
                'id'          => 4,
                'title'       => 'Perusahaan',
                'icon'        => 'far fa-plus',
                'amount'      => 999,
                'status'      => 'active',
                'created_at'  => Carbon::parse('2024-12-24 03:26:51'),
                'updated_at'  => Carbon::parse('2025-05-09 14:05:34'),
            ],
            [
                'id'          => 5,
                'title'       => 'Event',
                'icon'        => 'far fa-plus',
                'amount'      => 1550,          // 1.550 → tanpa titik
                'status'      => 'active',
                'created_at'  => Carbon::parse('2024-12-24 23:27:04'),
                'updated_at'  => Carbon::parse('2025-05-09 14:05:23'),
            ],
        ];

        // Cara 1: Pakai DB facade (paling aman untuk force ID)
        DB::table('section_completecount')->insert($data);
    }
}
