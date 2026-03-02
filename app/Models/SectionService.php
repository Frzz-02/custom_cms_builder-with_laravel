<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionService extends Model
{
    protected $table = 'section_service';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'content',
        'image',
        'image_featured',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
    

    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

}
