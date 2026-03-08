<?php

namespace App\Models\Config;

use App\Enums\ContainerStructure as ContainerStructureEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSize($query)
    {
        return $query->where('category', ContainerStructureEnum::SIZE);
    }

    public function scopeType($query)
    {
        return $query->where('category', ContainerStructureEnum::TYPE);
    }

    public function scopeCondition($query)
    {
        return $query->where('category', ContainerStructureEnum::CONDITION);
    }

    public function scopeFeature($query)
    {
        return $query->where('category', ContainerStructureEnum::FEATURE);
    }
}
