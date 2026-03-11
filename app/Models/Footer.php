<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $table = 'footer_content';

    protected $fillable = [
        // Company Info
        'company_name',
        'company_tagline',
        'company_address',
        'company_phone',
        'company_email',
        'company_whatsapp',
        'company_website',
        
        // Contact Column
        'contact_column_title',
        'contact_phone',
        'contact_link_1_label',
        'contact_link_1_url',
        'contact_link_2_label',
        'contact_link_2_url',
        'contact_link_3_label',
        'contact_link_3_url',
        
        // Product Column
        'product_column_title',
        'product_link_1_label',
        'product_link_1_url',
        'product_link_2_label',
        'product_link_2_url',
        'product_link_3_label',
        'product_link_3_url',
        
        // Media Coverage
        'media_column_title',
        'media_1_name',
        'media_1_url',
        'media_2_name',
        'media_2_url',
        'media_3_name',
        'media_3_url',
        'media_4_name',
        'media_4_url',
        
        // Legal Column
        'legal_column_title',
        'legal_link_1_label',
        'legal_link_1_url',
        'legal_link_2_label',
        'legal_link_2_url',
        'legal_whatsapp_label',
        'legal_whatsapp_number',
        'legal_whatsapp_url',
        'legal_website_label',
        'legal_website_url',
        
        // Social Media
        'facebook_url',
        'facebook_enabled',
        'instagram_url',
        'instagram_enabled',
        'linkedin_url',
        'linkedin_enabled',
        'tiktok_url',
        'tiktok_enabled',
        'twitter_url',
        'twitter_enabled',
        'youtube_url',
        'youtube_enabled',
        
        // Guarantee Badge
        'guarantee_enabled',
        'guarantee_text',
        'guarantee_subtitle',
        'guarantee_icon_path',
        
        // WhatsApp Float
        'whatsapp_float_enabled',
        'whatsapp_float_number',
        'whatsapp_float_message',
        'whatsapp_float_position',
        
        // Copyright
        'copyright_text',
        'copyright_year',
        'copyright_credit',
        
        // Styling
        'footer_background_color',
        'footer_text_color',
        'footer_link_color',
        'footer_link_hover_color',
        
        // Meta
        'is_active',
    ];

    protected $casts = [
        'facebook_enabled' => 'boolean',
        'instagram_enabled' => 'boolean',
        'linkedin_enabled' => 'boolean',
        'tiktok_enabled' => 'boolean',
        'twitter_enabled' => 'boolean',
        'youtube_enabled' => 'boolean',
        'guarantee_enabled' => 'boolean',
        'whatsapp_float_enabled' => 'boolean',
        'is_active' => 'boolean',
        'copyright_year' => 'integer',
    ];


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
