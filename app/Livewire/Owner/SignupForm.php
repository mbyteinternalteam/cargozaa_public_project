<?php

namespace App\Livewire\Owner;

use App\Enums\BusinessType;
use App\Enums\KYCStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\KycAccount;
use App\Models\Owner;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SignupForm extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $fullName = '';

    #[Validate('required|string|email:rfc,dns|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|max:30')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $businessName = '';

    #[Validate('required|string|in:sole_proprietor,sdn_bhd,berhad,limited_liability_partnership')]
    public string $businessType = '';

    /**
     * @return array<string, string>
     */
    public function businessTypeOptions(): array
    {
        return BusinessType::options();
    }

    #[Validate('required|string|max:50')]
    public string $taxId = '';

    #[Validate('required|string|max:500')]
    public string $registeredAddress = '';

    #[Validate('required|string|max:50')]
    public string $registeredCity = '';

    #[Validate('required|string|max:10')]
    public string $registeredPostcode = '';

    #[Validate('required|integer|exists:states,id')]
    public int|string $registeredStateId = '';

    #[Validate('required|string|max:50')]
    public string $ownerIcNumber = '';

    #[Validate('required|string|in:nric,passport')]
    public string $ownerIcType = '';

    #[Validate('required|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $ssmCertificate;

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|string|min:8|same:password')]
    public string $passwordConfirmation = '';

    #[Validate('accepted')]
    public bool $businessVerified = false;

    #[Validate('accepted')]
    public bool $acceptTerms = false;

    public bool $showSuccessModal = false;

    public function clearSsmCertificate(): void
    {
        $this->reset('ssmCertificate');
        $this->resetErrorBag('ssmCertificate');
    }

    public function closeSuccessModal()
    {
        $this->reset();
        return redirect()->route('owner.login');
    }

    public function submit(): void
    {
        // dd($this->all());
        $this->validate();

        DB::transaction(function (): void {
            $user = User::query()->create([
                'name' => $this->fullName,
                'email' => $this->email,
                'password' => $this->password,
                'user_type' => UserType::OWNER,
                'status' => UserStatus::Pending,
            ]);

            $owner = Owner::query()->create([
                'user_id' => $user->id,
                'business_name' => $this->businessName,
                'business_type' => $this->businessType,
                'ssm_number' => $this->taxId,
                'phone' => $this->phone,
                'registered_address' => $this->registeredAddress,
                'registered_city' => $this->registeredCity,
                'registered_postcode' => $this->registeredPostcode,
                'registered_state' => optional(State::query()->find($this->registeredStateId))->name,
                'tax_id' => $this->taxId,
                'identity_document_type' => $this->ownerIcType,
                'identity_number' => $this->ownerIcNumber,
                'terms_accepted' => true,
                'privacy_policy_accepted' => true,
            ]);

            $path = $this->ssmCertificate->store("owner_documents/{$user->id}/ssm", 'public');

            $owner->forceFill([
                'ssm_document' => $path,
            ])->save();

            KycAccount::query()->create([
                'owner_id' => $owner->id,
                'kyc_status' => KYCStatus::Pending,
                'kyc_submitted_at' => now(),
            ]);
        });

        $this->showSuccessModal = true;
    }

    public function render()
    {
        return view('livewire.owner.signup-form');
    }
}

