<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionTeam extends Model
{
    protected $fillable = [
        'name',
        'position',
        'image',
        'status',
        'link_profile_1',
        'link_profile_2',
        'link_profile_3',
        'link_profile_4',
    ];
    
}
