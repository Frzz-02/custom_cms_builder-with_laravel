<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionHero extends Model
{
    use HasFactory;

    protected $table = 'section_hero';

    protected $fillable = [
        'title',
        'title_2',
        'title_3',
        'subtitle_1',
        'subtitle_2',
        'subtitle_3',
        'description',
        'description_2',
        'description_3',
        'image',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
        'image_7',
        'image_8',
        'image_9',
        'image_10',
        'image_11',
        'image_12',
        'image_13',
        'image_14',
        'image_15',
        'image_16',
        'image_17',
        'image_18',
        'image_background',
        'image_background_2',
        'image_background_3',
        'action_label',
        'action_label_2',
        'action_label_3',
        'action_url',
        'action_url_2',
        'action_url_3',
        'video_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the shortcodes for the hero section.
     */
    public function shortcodes()
    {
        return $this->hasMany(PageShortcode::class, 'section_hero_id');
    }
}
