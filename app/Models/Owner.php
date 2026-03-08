<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'business_name',
        'business_type',
        'ssm_number',
        'ssm_document',
        'phone',
        'website',
        'registered_address',
        'registered_city',
        'registered_state',
        'registered_postcode',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'bank_branch',
        'tax_id',
        'identity_document',
        'identity_document_type',
        'identity_number',
        'bank_statement',
        'terms_accepted',
        'privacy_policy_accepted',
    ];

    protected function casts(): array
    {
        return [
            'bank_statement' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function kycAccounts()
    {
        return $this->hasMany(KycAccount::class);
    }
}
