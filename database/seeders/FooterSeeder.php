<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('footer_content')->insert([
            // Company Info
            'company_name' => 'APEX WORKS',
            'company_tagline' => 'YOGYAKARTA',
            'company_address' => 'Jl. Cifor Batuhulung No.Rt.03/02, Bogor, Jawa Barat 16116',
            'company_phone' => '+62 813-1650-9191',
            'company_email' => 'contact@apexworks.com',
            'company_whatsapp' => '+62 813-1650-9191',
            'company_website' => 'apexWorks.com',
            
            // Contact Column
            'contact_column_title' => 'Hubungi Kami',
            'contact_phone' => '+62 813-1650-9191',
            'contact_link_1_label' => 'Tentang Kami',
            'contact_link_1_url' => '/tentang-kami',
            'contact_link_2_label' => 'Portfolio',
            'contact_link_2_url' => '/portfolio',
            'contact_link_3_label' => 'Blog',
            'contact_link_3_url' => '/blog',
            
            // Product Column
            'product_column_title' => 'Produk',
            'product_link_1_label' => 'Produk',
            'product_link_1_url' => '/produk',
            'product_link_2_label' => 'FAQ',
            'product_link_2_url' => '/faq',
            'product_link_3_label' => 'Karir',
            'product_link_3_url' => '/karir',
            
            // Media Coverage
            'media_column_title' => 'DILIPUT OLEH',
            'media_1_name' => 'Kompas.com',
            'media_1_url' => 'https://kompas.com',
            'media_2_name' => 'Detik.com',
            'media_2_url' => 'https://detik.com',
            'media_3_name' => 'Tribunnews.com',
            'media_3_url' => 'https://tribunnews.com',
            'media_4_name' => 'CNN Indonesia',
            'media_4_url' => 'https://cnnindonesia.com',
            
            // Legal Column
            'legal_column_title' => 'Privacy / Legal',
            'legal_link_1_label' => 'Privacy / Legal',
            'legal_link_1_url' => '/privacy',
            'legal_link_2_label' => 'Syarat & Ketentuan',
            'legal_link_2_url' => '/terms',
            'legal_whatsapp_label' => 'WA',
            'legal_whatsapp_number' => '+62 813-1650-9191',
            'legal_whatsapp_url' => 'https://wa.me/6281316509191',
            'legal_website_label' => 'apexworks.com',
            'legal_website_url' => 'https://apexworks.com',
            
            // Social Media
            'facebook_url' => 'https://facebook.com/lanyardkendal',
            'facebook_enabled' => true,
            'instagram_url' => 'https://instagram.com/lanyardkendal',
            'instagram_enabled' => true,
            'linkedin_url' => 'https://linkedin.com/company/lanyardkendal',
            'linkedin_enabled' => true,
            'tiktok_url' => 'https://tiktok.com/@lanyardkendal',
            'tiktok_enabled' => true,
            
            // Guarantee Badge
            'guarantee_enabled' => true,
            'guarantee_text' => 'GARANSI 100%',
            'guarantee_subtitle' => 'BEST QUALITY GUARANTEE',
            'guarantee_icon_path' => 'assets/images/shield-icon.svg',
            
            // WhatsApp Float
            'whatsapp_float_enabled' => true,
            'whatsapp_float_number' => '+62 813-1650-9191',
            'whatsapp_float_message' => 'Halo, saya ingin bertanya tentang produk Lanyard Kendal',
            'whatsapp_float_position' => 'bottom-right',
            
            // Copyright
            'copyright_text' => 'ApexWorks © 2026',
            'copyright_year' => 2026,
            'copyright_credit' => 'by ApexWorks Team',
            
            // Styling
            'footer_background_color' => '#0a0e27',
            'footer_text_color' => '#ffffff',
            'footer_link_color' => '#9ca3af',
            'footer_link_hover_color' => '#ffffff',
            
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
