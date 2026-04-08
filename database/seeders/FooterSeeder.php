<?php

namespace Database\Seeders;

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
            // Company Info - Berdasarkan Brand Mitra Com
            'company_name' => 'MITRA COM',
            'company_tagline' => 'SOLUSI PENGADAAN TKDN',
            'company_address' => 'Gedung Mitra Com, Lantai 5, Jakarta Selatan, DKI Jakarta 12345',
            'company_phone' => '+62 812-3456-7890',
            'company_email' => 'info@mitracom.id',
            'company_whatsapp' => '+62 812-3456-7890',
            'company_website' => 'mitracom.id',
            
            // Contact Column
            'contact_column_title' => 'Layanan Pelanggan',
            'contact_phone' => '+62 812-3456-7890',
            'contact_link_1_label' => 'Tentang Kami',
            'contact_link_1_url' => '/tentang-kami',
            'contact_link_2_label' => 'Prosedur Pengadaan',
            'contact_link_2_url' => '/prosedur',
            'contact_link_3_label' => 'Hubungi Kami',
            'contact_link_3_url' => '/kontak',
            
            // Product Column
            'product_column_title' => 'Produk & Sertifikasi',
            'product_link_1_label' => 'Katalog TKDN',
            'product_link_1_url' => '/katalog-tkdn',
            'product_link_2_label' => 'e-Katalog LKPP',
            'product_link_2_url' => '/e-katalog',
            'product_link_3_label' => 'Bantuan INAPROC',
            'product_link_3_url' => '/bantuan-inaproc',
            
            // Media Coverage / Partnerships (Relevan dengan instansi)
            'media_column_title' => 'MITRA STRATEGIS',
            'media_1_name' => 'LKPP Indonesia',
            'media_1_url' => 'https://lkpp.go.id',
            'media_2_name' => 'Kemenperin (TKDN)',
            'media_2_url' => 'https://kemenperin.go.id',
            'media_3_name' => 'LPSE Nasional',
            'media_3_url' => 'https://lpse.lkpp.go.id',
            'media_4_name' => 'INAPROC',
            'media_4_url' => 'https://inaproc.id',
            
            // Legal Column
            'legal_column_title' => 'Informasi Hukum',
            'legal_link_1_label' => 'Kebijakan Privasi',
            'legal_link_1_url' => '/privacy-policy',
            'legal_link_2_label' => 'Syarat & Ketentuan',
            'legal_link_2_url' => '/terms-conditions',
            'legal_whatsapp_label' => 'Konsultasi Gratis',
            'legal_whatsapp_number' => '+62 812-3456-7890',
            'legal_whatsapp_url' => 'https://wa.me/6281234567890',
            'legal_website_label' => 'mitracom.id',
            'legal_website_url' => 'https://mitracom.id',
            
            // Social Media (Professional focus)
            'facebook_url' => 'https://facebook.com/mitracom.official',
            'facebook_enabled' => true,
            'instagram_url' => 'https://instagram.com/mitracom.id',
            'instagram_enabled' => true,
            'linkedin_url' => 'https://linkedin.com/company/mitracom-pengadaan',
            'linkedin_enabled' => true,
            'tiktok_url' => null,
            'tiktok_enabled' => false,
            
            // Guarantee Badge (Menonjolkan kualitas dan TKDN)
            'guarantee_enabled' => true,
            'guarantee_text' => 'GARANSI RESMI',
            'guarantee_subtitle' => 'SERTIFIKASI TKDN VALID',
            'guarantee_icon_path' => 'assets/images/shield-verified.svg',
            
            // WhatsApp Float (Call to Action yang lebih spesifik)
            'whatsapp_float_enabled' => true,
            'whatsapp_float_number' => '+62 812-3456-7890',
            'whatsapp_float_message' => 'Halo Mitra Com, saya ingin berkonsultasi mengenai pengadaan barang bersertifikasi TKDN.',
            'whatsapp_float_position' => 'bottom-right',
            
            // Copyright
            'copyright_text' => 'Mitra Com © 2026. All Rights Reserved.',
            'copyright_year' => 2026,
            'copyright_credit' => 'Solusi Pengadaan Terpercaya',
            
            // Styling (Sesuai dengan nuansa gambar: Putih & Biru Tua/Gelap)
            'footer_background_color' => '#111827', // Biru gelap profesional
            'footer_text_color' => '#f9fafb',
            'footer_link_color' => '#9ca3af',
            'footer_link_hover_color' => '#fb923c', // Aksen orange dari logo/button gambar 1
            
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}