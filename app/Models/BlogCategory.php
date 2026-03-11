<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';

    protected $fillable = [
        'status',
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];


    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_categories_id');
    }
    
    
    
    
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}