<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LaboratoryReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'laboratory_id',
        'user_id',
        'title',
        'content',
        'overall_rating',
        'research_rating',
        'supervision_rating',
        'environment_rating',
        'career_rating',
        'academic_year',
        'degree_type',
        'research_topic',
        'career_path',
        'images',
        'graduation_date',
        'is_verified',
        'is_anonymous',
        'helpful_count'
    ];

    protected $casts = [
        'images' => 'array',
        'graduation_date' => 'date',
        'is_verified' => 'boolean',
        'is_anonymous' => 'boolean'
    ];

    protected static function booted()
    {
        static::created(function ($review) {
            $review->laboratory->updateRatingStats();
        });

        static::updated(function ($review) {
            $review->laboratory->updateRatingStats();
        });

        static::deleted(function ($review) {
            $review->laboratory->updateRatingStats();
        });
    }

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function helpfulUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'laboratory_review_helpful');
    }

    /**
     * 匿名表示用のユーザー名を取得
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return '匿名ユーザー';
        }
        return $this->user->name ?? 'ユーザー';
    }

    /**
     * 総合評価に基づく星の数を取得
     */
    public function getStarsAttribute(): int
    {
        return min(5, max(1, $this->overall_rating));
    }

    /**
     * 学位種類の日本語名を取得
     */
    public function getDegreeTypeJapaneseAttribute(): string
    {
        $types = [
            'bachelor' => '学士',
            'master' => '修士',
            'doctor' => '博士',
            'undergraduate' => '学部生',
            'graduate' => '大学院生'
        ];

        return $types[$this->degree_type] ?? $this->degree_type;
    }

    /**
     * 各評価項目の平均を計算
     */
    public function getDetailedRatingsAttribute(): array
    {
        return [
            'research' => $this->research_rating,
            'supervision' => $this->supervision_rating,
            'environment' => $this->environment_rating,
            'career' => $this->career_rating
        ];
    }

    /**
     * 最新順でソート
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 評価順でソート
     */
    public function scopeByRating($query, $order = 'desc')
    {
        return $query->orderBy('overall_rating', $order);
    }

    /**
     * 参考になった順でソート
     */
    public function scopeByHelpful($query)
    {
        return $query->orderBy('helpful_count', 'desc');
    }

    /**
     * 学位種類でフィルタ
     */
    public function scopeByDegreeType($query, $degreeType)
    {
        return $query->where('degree_type', $degreeType);
    }

    /**
     * 年度でフィルタ
     */
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * 認証済みレビューのみ
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
