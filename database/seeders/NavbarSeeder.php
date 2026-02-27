<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Navbar;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // Navbar & Sidebar Menu
            [
                'menu_label' => 'HOME',
                'menu_slug' => 'home',
                'menu_url' => '/',
                'menu_icon' => 'fas fa-home',
                'menu_location' => 'both',
                'menu_order' => 1,
                'show_in_navbar' => true,
                'show_in_sidebar' => true,
                'is_button' => false,
                'is_active' => true,
            ],
            [
                'menu_label' => 'PRODUK',
                'menu_slug' => 'produk',
                'menu_url' => '/produk',
                'menu_icon' => 'fas fa-box',
                'menu_location' => 'both',
                'menu_order' => 2,
                'show_in_navbar' => false,
                'show_in_sidebar' => true,
                'is_button' => false,
                'is_active' => true,
            ],
            [
                'menu_label' => 'TESTIMONI',
                'menu_slug' => 'testimoni',
                'menu_url' => '/testimoni',
                'menu_icon' => 'fas fa-comments',
                'menu_location' => 'both',
                'menu_order' => 3,
                'show_in_navbar' => false,
                'show_in_sidebar' => true,
                'is_button' => false,
                'is_active' => true,
            ],
            // [
            //     'menu_label' => 'PORTOFOLIO',
            //     'menu_slug' => 'portofolio',
            //     'menu_url' => '/portofolio',
            //     'menu_icon' => 'fas fa-images',
            //     'menu_location' => 'both',
            //     'menu_order' => 4,
            //     'show_in_navbar' => false,
            //     'show_in_sidebar' => true,
            //     'is_button' => false,
            //     'is_active' => true,
            // ],
            [
                'menu_label' => 'BLOG',
                'menu_slug' => 'blog',
                'menu_url' => '/blog',
                'menu_icon' => 'fas fa-newspaper',
                'menu_location' => 'both',
                'menu_order' => 5,
                'show_in_navbar' => false,
                'show_in_sidebar' => true,
                'is_button' => false,
                'is_active' => true,
            ],
            [
                'menu_label' => 'KONTAK',
                'menu_slug' => 'kontak',
                'menu_url' => '/kontak',
                'menu_icon' => 'fas fa-envelope',
                'menu_location' => 'both',
                'menu_order' => 6,
                'show_in_navbar' => false,
                'show_in_sidebar' => true,
                'is_button' => false,
                'is_active' => true,
            ],
            // Navbar Only (Top Menu)
            [
                'menu_label' => 'SEARCH',
                'menu_slug' => 'search',
                'menu_url' => '#',
                'menu_icon' => 'fas fa-search',
                'menu_location' => 'navbar',
                'menu_order' => 7,
                'show_in_navbar' => true,
                'show_in_sidebar' => false,
                'is_button' => false,
                'is_active' => true,
            ],
            [
                'menu_label' => 'CONTACT',
                'menu_slug' => 'contact',
                'menu_url' => '/kontak',
                'menu_icon' => null,
                'menu_location' => 'navbar',
                'menu_order' => 8,
                'show_in_navbar' => true,
                'show_in_sidebar' => false,
                'is_button' => false,
                'is_active' => true,
            ],
            // Button Special
            [
                'menu_label' => 'APEX SHOP',
                'menu_slug' => 'shop',
                'menu_url' => '/shop',
                'menu_icon' => 'fas fa-shopping-bag',
                'menu_location' => 'navbar',
                'menu_order' => 9,
                'show_in_navbar' => true,
                'show_in_sidebar' => false,
                'is_button' => true,
                'is_active' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Navbar::create($menu);
        }
    }
}
