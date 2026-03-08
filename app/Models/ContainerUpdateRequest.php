<?php

namespace App\Models;

use App\Enums\ContainerUpdateRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerUpdateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_id',
        'owner_id',
        'status',
        'data',
        'reviewed_by',
        'reviewed_at',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'status' => ContainerUpdateRequestStatus::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
