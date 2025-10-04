<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'icon',
        'is_active',
        'businesses_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'businesses_count' => 'integer'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
}
