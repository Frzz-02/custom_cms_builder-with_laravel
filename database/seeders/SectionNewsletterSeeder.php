<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SectionNewsletter;

class SectionNewsletterSeeder extends Seeder
{
    public function run(): void
    {
        SectionNewsletter::create([
            'title'        => 'Dapatkan Promo Eksklusif Gadget & Elektronik!',
            'subtitle'     => 'Update Mingguan Laptop & Smart Home',
            'action_label' => 'Daftar Sekarang',
            'placeholder'  => 'Masukkan alamat email Anda...',
            'status'       => 'active',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}