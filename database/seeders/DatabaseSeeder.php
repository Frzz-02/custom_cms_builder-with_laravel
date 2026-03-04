<?php

namespace Database\Seeders;

use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\FooterSeeder;
use Database\Seeders\NavbarSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SectionAboutSeeder;
use Database\Seeders\SectionBrandSeeder;
use Database\Seeders\SectionCompleteCountSeeder;
use Database\Seeders\SectionHeroSeeder;
use Database\Seeders\SectionNewsletterSeeder;
use Database\Seeders\SectionServiceSeeder;
use Database\Seeders\SectionTestimonialsSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            roleSeeder::class,
            UserSeeder::class,
            FooterSeeder::class,
            NavbarSeeder::class,
            SectionAboutSeeder::class,
            SectionBrandSeeder::class,
            SectionHeroSeeder::class,
            SectionTestimonialsSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            SectionServiceSeeder::class,
            BlogCategorySeeder::class,
            ContactSeeder::class,
            SectionNewsletterSeeder::class,
            SectionCompleteCountSeeder::class,            
            whatsappButtonSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
