<?php

namespace App\Models;

use App\Enums\ContainerStatus;
use App\Models\Config\ContainerStructure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'container';

    public function getContainerStructureName(): array
    {
        return [
            'type' => ContainerStructure::find($this->container_type)->name,
            'size' => ContainerStructure::find($this->container_size)->name,
            'condition' => ContainerStructure::find($this->container_condition)->name,
        ];
    }

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
        'latitude',
        'longitude',
        'full_address',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'daily_markup',
        'weekly_markup',
        'monthly_markup',
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
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'last_inspection_date' => 'date',
            'daily_rate' => 'decimal:2',
            'weekly_rate' => 'decimal:2',
            'monthly_rate' => 'decimal:2',
            'daily_markup' => 'decimal:2',
            'weekly_markup' => 'decimal:2',
            'monthly_markup' => 'decimal:2',
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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($container) {
            $container->display_id = 'CNT-'.str_pad((string) (Container::max('id') + 1), 5, '0', STR_PAD_LEFT);
        });
    }

    public function getListedDailyRateAttribute(): string
    {
        return number_format((float) $this->daily_rate + (float) $this->daily_markup, 2);
    }

    public function getListedWeeklyRateAttribute(): string
    {
        return number_format((float) $this->weekly_rate + (float) $this->weekly_markup, 2);
    }

    public function getListedMonthlyRateAttribute(): string
    {
        return number_format((float) $this->monthly_rate + (float) $this->monthly_markup, 2);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getActiveImage(): string
    {
        return $this->images[0] ?? '';
    }
}
