<?php

namespace Database\Seeders;

use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\FooterSeeder;
use Database\Seeders\NavbarSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SectionAboutSeeder;
use Database\Seeders\SectionBrandSeeder;
use Database\Seeders\SectionHeroSeeder;
use Database\Seeders\SectionServiceSeeder;
use Database\Seeders\SectionTestimonialsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ContactSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
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
            
        ]);
    }
}
