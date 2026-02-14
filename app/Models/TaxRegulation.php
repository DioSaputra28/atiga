<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRegulation extends Model
{
    /** @use HasFactory<\Database\Factories\TaxRegulationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'document_path',
        'document_name',
        'youtube_url',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }
}
