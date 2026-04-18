<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'status',
        'is_homepage',
        'title',
        'template',
        'header_style',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Get the shortcodes for the page.
     */
    public function shortcodes()
    {
        return $this->hasMany(PageShortcode::class, 'pages_id');
    }
}
