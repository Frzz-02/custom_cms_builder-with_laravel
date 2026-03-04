<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_title',
        'site_subtitle',
        'time_zone',
        'locale_language',
        'site_description',
        'site_keywords',
        'site_url',
        'site_logo',
        'site_logo_2',
        'favicon',
        'preloader',
    ];   
}
