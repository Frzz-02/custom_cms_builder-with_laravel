<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappButton extends Model
{
    protected $fillable = [
        'phone_number',
        'message',
        'offset_x',
        'offset_y',
        'position',
        'status',
    ];
}
