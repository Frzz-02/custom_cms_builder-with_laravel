<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_content', function (Blueprint $table) {
            $table->id();
            
            // ====================================
            // SECTION 1: COMPANY INFO (LEFT SIDE)
            // ====================================
            $table->string('company_name', 100)->default('LANYARD KENDAL');
            $table->string('company_tagline', 100)->default('BOGOR');
            $table->string('company_address')->nullable();
            $table->string('company_phone', 50)->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('company_whatsapp', 50)->nullable();
            $table->string('company_website')->nullable();
            
            // ====================================
            // SECTION 2: CONTACT COLUMN (Column 1)
            // ====================================
            $table->string('contact_column_title', 100)->default('Hubungi Kami');
            $table->string('contact_phone', 50)->nullable();
            $table->string('contact_link_1_label', 100)->default('Tentang Kami');
            $table->string('contact_link_1_url')->default('/tentang-kami');
            $table->string('contact_link_2_label', 100)->default('Portfolio');
            $table->string('contact_link_2_url')->default('/portfolio');
            $table->string('contact_link_3_label', 100)->default('Blog');
            $table->string('contact_link_3_url')->default('/blog');
            
            // ====================================
            // SECTION 3: PRODUCT COLUMN (Column 2)
            // ====================================
            $table->string('product_column_title', 100)->default('Produk');
            $table->string('product_link_1_label', 100)->default('Produk');
            $table->string('product_link_1_url')->default('/produk');
            $table->string('product_link_2_label', 100)->default('FAQ');
            $table->string('product_link_2_url')->default('/faq');
            $table->string('product_link_3_label', 100)->default('Karir');
            $table->string('product_link_3_url')->default('/karir');
            
            // ====================================
            // SECTION 4: MEDIA COVERAGE (Column 3)
            // ====================================
            $table->string('media_column_title', 100)->default('DILIPUT OLEH');
            $table->string('media_1_name', 100)->default('Kompas.com');
            $table->string('media_1_url')->default('https://kompas.com');
            $table->string('media_2_name', 100)->default('Detik.com');
            $table->string('media_2_url')->default('https://detik.com');
            $table->string('media_3_name', 100)->default('Tribunnews.com');
            $table->string('media_3_url')->default('https://tribunnews.com');
            $table->string('media_4_name', 100)->default('CNN Indonesia');
            $table->string('media_4_url')->default('https://cnnindonesia.com');
            
            // ====================================
            // SECTION 5: LEGAL COLUMN (Column 4)
            // ====================================
            $table->string('legal_column_title', 100)->default('Privacy / Legal');
            $table->string('legal_link_1_label', 100)->default('Privacy / Legal');
            $table->string('legal_link_1_url')->default('/privacy');
            $table->string('legal_link_2_label', 100)->default('Syarat & Ketentuan');
            $table->string('legal_link_2_url')->default('/terms');
            $table->string('legal_whatsapp_label', 100)->default('WA');
            $table->string('legal_whatsapp_number', 50)->nullable();
            $table->string('legal_whatsapp_url')->nullable();
            $table->string('legal_website_label', 100)->default('lanyardkendal.com');
            $table->string('legal_website_url')->default('https://lanyardkendal.com');
            
            // ====================================
            // SECTION 6: SOCIAL MEDIA LINKS
            // ====================================
            $table->string('facebook_url')->nullable();
            $table->boolean('facebook_enabled')->default(true);
            $table->string('instagram_url')->nullable();
            $table->boolean('instagram_enabled')->default(true);
            $table->string('linkedin_url')->nullable();
            $table->boolean('linkedin_enabled')->default(true);
            $table->string('tiktok_url')->nullable();
            $table->boolean('tiktok_enabled')->default(true);
            $table->string('twitter_url')->nullable();
            $table->boolean('twitter_enabled')->default(false);
            $table->string('youtube_url')->nullable();
            $table->boolean('youtube_enabled')->default(false);
            
            // ====================================
            // SECTION 7: GUARANTEE BADGE
            // ====================================
            $table->boolean('guarantee_enabled')->default(true);
            $table->string('guarantee_text', 100)->default('GARANSI 100%');
            $table->string('guarantee_subtitle', 100)->default('BEST QUALITY GUARANTEE');
            $table->string('guarantee_icon_path')->nullable();
            
            // ====================================
            // SECTION 8: WHATSAPP FLOATING BUTTON
            // ====================================
            $table->boolean('whatsapp_float_enabled')->default(true);
            $table->string('whatsapp_float_number', 50)->nullable();
            $table->string('whatsapp_float_message')->default('Halo, saya ingin bertanya tentang produk Lanyard Kendal');
            $table->string('whatsapp_float_position', 20)->default('bottom-right');
            
            // ====================================
            // SECTION 9: COPYRIGHT
            // ====================================
            $table->string('copyright_text')->default('LanyardKendal © 2026');
            $table->year('copyright_year')->default(2026);
            $table->string('copyright_credit', 100)->default('by LanyardKendal Team');
            
            // ====================================
            // SECTION 10: STYLING & SETTINGS
            // ====================================
            $table->string('footer_background_color', 50)->default('#0a0e27');
            $table->string('footer_text_color', 50)->default('#ffffff');
            $table->string('footer_link_color', 50)->default('#9ca3af');
            $table->string('footer_link_hover_color', 50)->default('#ffffff');
            
            // ====================================
            // META
            // ====================================
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_content');
    }
};
