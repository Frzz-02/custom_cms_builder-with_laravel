<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageShortcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_completecount_id',
        'section_newsletter_id',
        'contact_id',
        'section_brand_id',
        'section_testimoni_id',
        'section_team_id',
        'section_service_id',
        'section_hero_id',
        'packages_id',
        'section_about_id',
        'pages_id',
        'faq_categories_id',
        'product_category_id',
        'sort_id',
        'blog_limit',
        'product_category_limit',
        'title',
        'subtitle',
        'heading',
        'content',
        'image',
        'service_title',
        'team_title',
        'testimonials_title',
        'testimonials_subtitle',
        'team_subtitle',
        'service_subtitle',
        'service_description',
        'brand_count',
        'brand_title',
        'contact_title_1',
        'contact_title_2',
        'contact_subtitle',
        'latestnews_title',
        'latestnews_subtitle',
        'latestnews_description',
        'pricing_title',
        'pricing_subtitle',
        'pricing_description',
        'promo_title',
        'promo_subtitle',
        'product_title',
        'product_subtitle',
        'comingsoon_title',
        'comingsoon_subtitle',
        'comingsoon_image',
        'comingsoon_placeholder',
        'product_category_style',
        'hero_style',
        'about_style',
        'pricing_style',
        'testimonials_style',
        'faq_style',
        'team_style',
        'latestnews_style',
        'service_style',
        'type',
    ];

    protected $casts = [
        'section_completecount_id' => 'array',
        'contact_id' => 'array',
        'section_brand_id' => 'array',
        'section_testimoni_id' => 'array',
        'section_team_id' => 'array',
        'section_service_id' => 'array',
        'product_category_id' => 'array',
        'packages_id' => 'array',
    ];

    /**
     * Get the page that owns the shortcode.
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'pages_id');
    }

    /**
     * Get the hero section associated with the shortcode.
     */
    public function hero()
    {
        return $this->belongsTo(SectionHero::class, 'section_hero_id');
    }

    /**
     * Get the about section associated with the shortcode.
     */
    public function about()
    {
        return $this->belongsTo(SectionAbout::class, 'section_about_id');
    }
}
