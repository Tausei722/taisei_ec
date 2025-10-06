<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'address',
        'phone',
        'website',
        'business_hours',
        'images',
        'latitude',
        'longitude',
        'average_rating',
        'total_reviews',
        'is_active'
    ];

    protected $casts = [
        'business_hours' => 'array',
        'images' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'average_rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function updateRatingStats(): void
    {
        $reviews = $this->reviews();
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        $this->update([
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 2)
        ]);
    }

    public function getStarDistributionAttribute(): array
    {
        $distribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        $counts = $this->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        foreach ($counts as $rating => $count) {
            $distribution[$rating] = $count;
        }

        return $distribution;
    }
}