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
        Schema::create('page_shortcodes', function (Blueprint $table) {
            $table->id();
            $table->json('section_completecount_id')->nullable();
            $table->unsignedBigInteger('section_newsletter_id')->nullable();
            $table->json('contact_id')->nullable();
            $table->json('section_brand_id')->nullable();
            $table->json('section_testimoni_id')->nullable();
            $table->json('section_team_id')->nullable();
            $table->json('section_service_id')->nullable();
            $table->unsignedBigInteger('section_hero_id')->nullable();
            $table->json('packages_id')->nullable();
            $table->unsignedBigInteger('section_about_id')->nullable();
            $table->foreignId('pages_id')->constrained('pages')->onDelete('cascade');
            $table->unsignedBigInteger('faq_categories_id')->nullable();
            $table->json('product_category_id')->nullable();

            $table->integer('sort_id')->nullable();
            $table->integer('blog_limit')->nullable();
            $table->integer('product_category_limit')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('heading')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('service_title')->nullable();
            $table->string('team_title')->nullable();
            $table->string('testimonials_title')->nullable();
            $table->string('testimonials_subtitle')->nullable();
            $table->string('team_subtitle')->nullable();
            $table->string('service_subtitle')->nullable();
            $table->text('service_description')->nullable();
            $table->string('brand_count')->nullable();
            $table->string('brand_title')->nullable();
            $table->string('contact_title_1')->nullable();
            $table->string('contact_title_2')->nullable();
            $table->string('contact_subtitle')->nullable();
            $table->string('latestnews_title')->nullable();
            $table->string('latestnews_subtitle')->nullable();
            $table->text('latestnews_description')->nullable();
            $table->string('pricing_title')->nullable();
            $table->string('pricing_subtitle')->nullable();
            $table->text('pricing_description')->nullable();
            $table->string('promo_title')->nullable();
            $table->string('promo_subtitle')->nullable();
            $table->string('product_title')->nullable();
            $table->string('product_subtitle')->nullable();
            $table->string('comingsoon_title')->nullable();
            $table->string('comingsoon_subtitle')->nullable();
            $table->string('comingsoon_image')->nullable();
            $table->string('comingsoon_placeholder')->nullable();
      
            $table->integer('product_category_style')->nullable();
            $table->string('hero_style')->nullable();
            $table->string('about_style')->nullable();
            $table->string('pricing_style')->nullable();
            $table->string('testimonials_style')->nullable();
            $table->string('faq_style')->nullable();
            $table->string('team_style')->nullable();
            $table->string('latestnews_style')->nullable();
            $table->string('service_style')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_shortcodes');
    }
};
