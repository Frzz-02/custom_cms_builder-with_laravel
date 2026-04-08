<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin - ID 0 (Data Khusus untuk Keamanan)
        // PERHATIAN: User ini memiliki ID 0 sebagai penanda khusus di database
        // Jangan hapus atau modifikasi user ini!
        User::create([
            'id' => 0,
            'name' => 'Kaito Kid',
            'email' => 'kaito.kid@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);
    }
}
