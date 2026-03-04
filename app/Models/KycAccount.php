<?php

namespace App\Models;

use App\Enums\KYCStatus;
use Illuminate\Database\Eloquent\Model;

class KycAccount extends Model
{
    protected $fillable = [
        'owner_id',
        'kyc_status',
        'kyc_submitted_at',
        'kyc_reviewed_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'rejection_details',
    ];

    protected function casts(): array
    {
        return [
            'kyc_status' => KYCStatus::class,
            'kyc_submitted_at' => 'datetime',
            'kyc_reviewed_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
