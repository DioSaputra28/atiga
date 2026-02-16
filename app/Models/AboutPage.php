<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    /** @use HasFactory<\Database\Factories\AboutPageFactory> */
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'intro_text',
        'stats_json',
        'vision_json',
        'mission_json',
        'core_values_json',
        'cta_title',
        'cta_description',
        'cta_label',
        'cta_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'stats_json' => 'array',
            'vision_json' => 'array',
            'mission_json' => 'array',
            'core_values_json' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
