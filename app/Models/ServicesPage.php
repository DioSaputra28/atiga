<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesPage extends Model
{
    /** @use HasFactory<\Database\Factories\ServicesPageFactory> */
    use HasFactory;

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_highlight',
        'hero_description',
        'main_services_json',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'main_services_json' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
