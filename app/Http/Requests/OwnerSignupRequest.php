<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerSignupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],

            'business_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'max:50'],

            'registered_address' => ['required', 'string', 'max:500'],
            'registered_postcode' => ['required', 'string', 'max:10'],
            'registered_state_id' => ['required', 'integer', 'exists:states,id'],

            'owner_ic_number' => ['required', 'string', 'max:50'],
            'owner_ic_type' => ['required', 'string', 'in:nric,passport'],

            'ssm_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'business_verified' => ['accepted'],
            'accept_terms' => ['accepted'],
        ];
    }
}
