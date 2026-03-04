<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'alternate_phone',
        'company_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'delivery_address',
        'same_as_billing',
        'ic_number',
        'ic_type',
        'is_corporate',
        'business_registration_no',
        'tax_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
