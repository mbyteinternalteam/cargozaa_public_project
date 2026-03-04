<?php

namespace App\Http\Controllers;

use App\Enums\KYCStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Requests\OwnerSignupRequest;
use App\Models\KycAccount;
use App\Models\Owner;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OwnerAuthController extends Controller
{
    public function create(): View
    {
        return view('owner.auth.signup');
    }

    public function store(OwnerSignupRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $user = User::query()->create([
                'name' => $request->string('full_name'),
                'email' => $request->string('email'),
                'password' => $request->string('password'),
                'user_type' => UserType::OWNER,
                'status' => UserStatus::Pending,
            ]);

            $owner = Owner::query()->create([
                'user_id' => $user->id,
                'business_name' => $request->string('business_name'),
                'business_type' => $request->string('business_type'),
                'ssm_number' => $request->string('tax_id'),
                'phone' => $request->string('phone'),
                'registered_address' => $request->string('registered_address'),
                'registered_postcode' => $request->string('registered_postcode'),
                'registered_state' => optional(State::query()->find($request->integer('registered_state_id')))->name,
                'tax_id' => $request->string('tax_id'),
                'identity_document_type' => $request->string('owner_ic_type'),
                'identity_number' => $request->string('owner_ic_number'),
                'terms_accepted' => true,
                'privacy_policy_accepted' => true,
            ]);

            if ($request->hasFile('ssm_certificate')) {
                $path = $request->file('ssm_certificate')->store('kyc/ssm-certificates', 'public');

                $owner->forceFill([
                    'ssm_document' => $path,
                ])->save();
            }

            KycAccount::query()->create([
                'owner_id' => $owner->id,
                'kyc_status' => KYCStatus::UnderReview,
                'kyc_submitted_at' => now(),
            ]);
        });

        return redirect()
            ->route('owner.signup')
            ->with('owner_signup_success', true);
    }
}
