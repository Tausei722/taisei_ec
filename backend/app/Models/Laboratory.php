<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laboratory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'university',
        'department',
        'professor_name',
        'professor_title',
        'research_fields',
        'lab_url',
        'email',
        'admission_info',
        'career_info',
        'student_count',
        'average_rating',
        'total_reviews',
        'images',
        'is_active'
    ];

    protected $casts = [
        'research_fields' => 'array',
        'images' => 'array',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(LaboratoryReview::class);
    }

    /**
     * 平均評価と口コミ数を更新
     */
    public function updateRatingStats(): void
    {
        $reviews = $this->reviews();
        $totalReviews = $reviews->count();

        if ($totalReviews > 0) {
            $averageRating = $reviews->avg('overall_rating');
        } else {
            $averageRating = 0;
        }

        $this->update([
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 2)
        ]);
    }

    /**
     * 研究分野の配列を文字列として取得
     */
    public function getResearchFieldsStringAttribute(): string
    {
        if (is_array($this->research_fields)) {
            return implode(', ', $this->research_fields);
        }
        return $this->research_fields ?? '';
    }

    /**
     * 大学名と学部名を組み合わせた文字列を取得
     */
    public function getFullDepartmentNameAttribute(): string
    {
        return $this->university . ' ' . $this->department;
    }

    /**
     * 指導教員の正式名称を取得
     */
    public function getFullProfessorNameAttribute(): string
    {
        if ($this->professor_title) {
            return $this->professor_title . ' ' . $this->professor_name;
        }
        return $this->professor_name;
    }

    /**
     * アクティブな研究室のスコープ
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 大学でフィルタリングするスコープ
     */
    public function scopeByUniversity($query, $university)
    {
        return $query->where('university', $university);
    }

    /**
     * 学部でフィルタリングするスコープ
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * 研究分野で検索するスコープ
     */
    public function scopeByResearchField($query, $field)
    {
        return $query->whereJsonContains('research_fields', $field);
    }

    /**
     * 検索スコープ
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('professor_name', 'like', "%{$search}%")
              ->orWhere('university', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhereJsonContains('research_fields', $search);
        });
    }
}
