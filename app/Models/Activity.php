<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'held_at',
        'location',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'held_at' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get the images for the activity.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ActivityImage::class)->orderBy('sort_order');
    }

    /**
     * Scope a query to only include featured activities.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by held date.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('held_at', 'desc');
    }

    /**
     * Scope a query to get upcoming activities.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('held_at', '>=', now());
    }

    /**
     * Scope a query to get past activities.
     */
    public function scopePast($query)
    {
        return $query->where('held_at', '<', now());
    }
}
