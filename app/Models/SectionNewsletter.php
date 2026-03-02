<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionNewsletter extends Model
{
    use HasFactory;

    protected $table = 'section_newsletters';

    protected $fillable = [
        'title',
        'subtitle',
        'action_label',
        'placeholder',
        'status',
    ];
}