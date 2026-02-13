<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Status constants.
     */
    public const STATUS_UPCOMING = 'upcoming';

    public const STATUS_ONGOING = 'ongoing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'price',
        'capacity',
        'status',
        'is_featured',
        'registration_link',
        'instructor_name',
        'thumbnail',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'price' => 'decimal:2',
            'capacity' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include upcoming trainings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', self::STATUS_UPCOMING);
    }

    /**
     * Scope a query to only include ongoing trainings.
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', self::STATUS_ONGOING);
    }

    /**
     * Scope a query to only include featured trainings.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by start date.
     */
    public function scopeUpcomingFirst($query)
    {
        return $query->orderBy('start_date', 'asc');
    }

    /**
     * Check if training is full.
     */
    public function isFull(): bool
    {
        return $this->capacity !== null && $this->capacity <= 0;
    }

    /**
     * Check if training is free.
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->isFree() ? 'Gratis' : 'Rp '.number_format($this->price, 0, ',', '.');
    }

    /**
     * Get duration in days.
     */
    public function getDurationInDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
