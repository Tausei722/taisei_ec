<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'business_id',
        'rating',
        'title',
        'content',
        'images',
        'visit_date',
        'is_verified',
        'helpful_count'
    ];

    protected $casts = [
        'images' => 'array',
        'visit_date' => 'date',
        'is_verified' => 'boolean',
        'helpful_count' => 'integer',
        'rating' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function helpfulUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'review_helpful')
                    ->withTimestamps();
    }

    public function isHelpfulBy(User $user): bool
    {
        return $this->helpfulUsers()->where('user_id', $user->id)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            $review->business->updateRatingStats();
        });

        static::updated(function ($review) {
            $review->business->updateRatingStats();
        });

        static::deleted(function ($review) {
            $review->business->updateRatingStats();
        });
    }
}