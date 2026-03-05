<?php

namespace App\Models;

use App\Enums\ContainerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'container';

    protected $fillable = [
        'owner_id',
        'display_id',
        'title',
        'description',
        'container_type',
        'container_size',
        'container_condition',
        'year_built',
        'last_inspection_date',
        'serial_number',
        'location',
        'full_address',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'length',
        'width',
        'height',
        'max_weight',
        'tare_weight',
        'cargo_capacity',
        'features',
        'images',
        'status',
        'status_reason',
        'unlisted',
    ];

    protected function casts(): array
    {
        return [
            'last_inspection_date' => 'date',
            'daily_rate' => 'decimal:2',
            'weekly_rate' => 'decimal:2',
            'monthly_rate' => 'decimal:2',
            'length' => 'decimal:2',
            'width' => 'decimal:2',
            'height' => 'decimal:2',
            'max_weight' => 'decimal:2',
            'tare_weight' => 'decimal:2',
            'cargo_capacity' => 'decimal:2',
            'features' => 'array',
            'images' => 'array',
            'status' => ContainerStatus::class,
            'unlisted' => 'bool',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
