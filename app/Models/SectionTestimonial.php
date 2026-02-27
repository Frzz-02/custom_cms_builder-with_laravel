<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionTestimonial extends Model
{
    protected $table = 'section_testimonials';

    protected $fillable = [
        'name',
        'position',
        'status',
        'image',
        'content',
        'star',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
