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
                'name' => 'Bambang Heru',
                'position' => 'Pejabat Pembuat Komitmen (PPK)',
                'status' => 'active',
                'image' => 'testimonials/bambang.jpg',
                'content' => 'Proses pengadaan barang sangat transparan dan akuntabel. Sertifikasi TKDN yang disediakan valid dan sangat membantu kami dalam memenuhi regulasi pemerintah.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indah Kusuma',
                'position' => 'Manager Operasional Perusahaan Swasta',
                'status' => 'active',
                'image' => 'testimonials/indah.jpg',
                'content' => 'Mitra Com adalah vendor yang sangat profesional. Produk yang dikirimkan memiliki garansi resmi dan kualitasnya sangat terjamin untuk kebutuhan operasional kami.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agus Setiawan',
                'position' => 'Bagian Logistik Instansi Daerah',
                'status' => 'active',
                'image' => 'testimonials/agus.jpg',
                'content' => 'Sangat terbantu dengan adanya Mitra Com di e-Katalog LKPP. Proses transaksi jadi jauh lebih cepat, aman, tanpa ribet, dan tim pendampingannya sangat responsif.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'position' => 'Kepala Biro Umum',
                'status' => 'active',
                'image' => 'testimonials/siti.jpg',
                'content' => 'Kami mengapresiasi komitmen Mitra Com dalam menyediakan produk dalam negeri. Dokumentasi lengkap, pengiriman tepat waktu, dan sangat kooperatif.',
                'star' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'position' => 'Konsultan Pengadaan',
                'status' => 'non-active',
                'image' => 'testimonials/dedi.jpg',
                'content' => 'Selalu merekomendasikan Mitra Com untuk pengadaan barang jasa karena kepatuhan mereka terhadap regulasi INAPROC dan standar teknis yang tinggi.',
                'star' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}