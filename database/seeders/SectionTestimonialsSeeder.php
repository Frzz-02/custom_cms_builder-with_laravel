<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('section_testimonials')->insert([
            [
                'name' => 'Andi Pratama',
                'position' => 'Pemilik Bengkel Mobil',
                'status' => 'active',
                'image' => 'testimonials/andi.jpg',
                'content' => 'Spare part yang saya beli sangat berkualitas dan original. Pengiriman cepat dan pelayanan sangat memuaskan.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rina Wijaya',
                'position' => 'Pengusaha Rental Mobil',
                'status' => 'active',
                'image' => 'testimonials/rina.jpg',
                'content' => 'Harga lebih terjangkau dibanding tempat lain dan kualitas tetap terjaga. Sangat recommended untuk kebutuhan bengkel.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'Teknisi Otomotif',
                'status' => 'active',
                'image' => 'testimonials/budi.jpg',
                'content' => 'Produk lengkap dari oli, kampas rem, hingga komponen mesin. Saya tidak perlu cari ke tempat lain lagi.',
                'star' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahma',
                'position' => 'Pemilik Motor Sport',
                'status' => 'active',
                'image' => 'testimonials/siti.jpg',
                'content' => 'Spare part motor tersedia lengkap dan kualitasnya sangat baik. Pelayanan ramah dan profesional.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'position' => 'Customer Setia',
                'status' => 'non-active',
                'image' => 'testimonials/dedi.jpg',
                'content' => 'Sudah beberapa kali belanja di sini dan selalu puas dengan kualitas produk serta kecepatan pengiriman.',
                'star' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
