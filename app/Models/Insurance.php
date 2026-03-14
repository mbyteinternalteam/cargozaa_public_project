<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    /** @use HasFactory<\Database\Factories\InsuranceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'daily_rate',
        'coverage_details',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'daily_rate' => 'decimal:2',
            'coverage_details' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
