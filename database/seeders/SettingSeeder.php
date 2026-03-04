<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::create([
            'site_title' => 'Mitracom',
            'site_subtitle' => 'Your Gateway to Excellence',
            'time_zone' => 'UTC',
            'locale_language' => 'en',
            'site_description' => 'Mitracom is a leading company providing top-notch services and solutions to clients worldwide.',
            'site_keywords' => 'Mitracom, services, solutions, excellence, global',
            'site_url' => 'https://www.mitracom.com',
            'site_logo' => null,
            'site_logo_2' => null,
            'favicon' => null,
            'preloader' => null,
        ]);
    }
}
