<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsappButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data untuk Whatsapp Button
        $whatsappButtons = [
            [
                'phone_number' => '+0987654321',
                'message' => 'Hi there! Need assistance?',
                'offset_x' => 20,
                'offset_y' => 20,
                'position' => 'bottom-left',
                'status' => 'active',
            ]
        ];

        foreach ($whatsappButtons as $button) {
            \App\Models\WhatsappButton::create($button);
        }
    }
}
