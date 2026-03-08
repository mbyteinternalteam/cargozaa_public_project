<?php

namespace App\Livewire\Owner;

use App\Enums\BusinessType;
use App\Enums\UserType;
use App\Models\Owner;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePage extends Component
{
    use WithFileUploads;

    public bool $isEditing = false;

    public bool $saved = false;

    public bool $isFirstTime = false;

    #[Validate('required|string|max:255')]
    public string $fullName = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|max:255')]
    public string $businessName = '';

    #[Validate('required|string|in:sole_proprietor,sdn_bhd,berhad,limited_liability_partnership')]
    public string $businessType = '';

    #[Validate('required|string|max:50')]
    public string $ssmNumber = '';

    #[Validate('required|string|max:30')]
    public string $phone = '';

    #[Validate('required|string|max:500')]
    public string $registeredAddress = '';

    #[Validate('required|string|max:50')]
    public string $registeredCity = '';

    #[Validate('required|string|max:10')]
    public string $registeredPostcode = '';

    #[Validate('required|integer|exists:states,id')]
    public int|string $registeredStateId = '';

    #[Validate('nullable|url|max:255')]
    public ?string $website = null;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $profilePicture = null;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $ssmCertificate = null;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $identityDocument = null;

    #[Validate('required|string|max:50')]
    public string $ownerIcNumber = '';

    #[Validate('required|string|in:nric,passport')]
    public string $ownerIcType = '';

    #[Validate('nullable|string|max:100')]
    public ?string $bankName = null;

    #[Validate('nullable|string|max:50')]
    public ?string $bankAccountNumber = null;

    #[Validate('nullable|string|max:255')]
    public ?string $bankAccountName = null;

    #[Validate('nullable|string|max:255')]
    public ?string $bankBranch = null;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $bankStatement = null;

    public ?int $totalContainers = 0;

    public ?int $totalBookings = 0;

    public string $revenueMtd = 'RM 0';

    public string $successRate = '0%';

    public function mount(): void
    {
        $user = Auth::user();
        if (! $user || $user->user_type !== UserType::OWNER) {
            $this->redirectRoute('owner.login');

            return;
        }
        $owner = $user->owner;
        if (! $owner) {
            $this->redirectRoute('owner.signup');

            return;
        }
        $this->isFirstTime = (int) ($user->first_time ?? 0) === 0;
        $this->fillFromOwner($owner);
    }

    protected function fillFromOwner(Owner $owner): void
    {
        $user = $owner->user;
        $this->fullName = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->businessName = $owner->business_name ?? '';
        $this->businessType = $owner->business_type ?? '';
        $this->ssmNumber = $owner->ssm_number ?? '';
        $this->phone = $owner->phone ?? '';
        $this->registeredAddress = $owner->registered_address ?? '';
        $this->registeredCity = $owner->registered_city ?? '';
        $this->registeredPostcode = $owner->registered_postcode ?? '';
        $this->registeredStateId = (string) (State::query()->where('name', $owner->registered_state)->value('id') ?? '');
        $this->website = $owner->website;
        $this->ownerIcNumber = $owner->identity_number ?? '';
        $this->ownerIcType = $owner->identity_document_type ?? '';
        $this->bankName = $owner->bank_name;
        $this->bankAccountNumber = $owner->bank_account_number;
        $this->bankAccountName = $owner->bank_account_name;
        $this->bankBranch = $owner->bank_branch;
    }

    /**
     * @return array<string, string>
     */
    public function businessTypeOptions(): array
    {
        return BusinessType::options();
    }

    public function updatedProfilePicture(): void
    {
        $this->validate(['profilePicture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048']);
        $user = Auth::user();
        $owner = $user?->owner;
        if ($owner && $this->profilePicture) {
            $path = $this->profilePicture->store("owner_documents/{$user->id}/profile", 'public');
            $owner->update(['profile_picture' => $path]);
            $this->reset('profilePicture');
        }
    }

    public function edit(): void
    {
        $this->isEditing = true;
        $this->saved = false;
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->fillFromOwner(Auth::user()->owner);
        $this->reset('profilePicture', 'ssmCertificate', 'identityDocument', 'bankStatement');
        $this->resetValidation();
    }

    public function save()
    {
        $user = Auth::user();
        $owner = $user->owner;

        if ($this->isFirstTime) {
            $rules = [
                'ownerIcNumber' => 'required|string|max:50',
                'ownerIcType' => 'required|string|in:nric,passport',
                'identityDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'bankName' => 'required|string|max:100',
                'bankAccountNumber' => 'required|string|max:50',
                'bankAccountName' => 'required|string|max:255',
                'bankBranch' => 'nullable|string|max:255',
                'bankStatement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ];
            $this->validate($rules);

            $owner->update([
                'identity_number' => $this->ownerIcNumber,
                'identity_document_type' => $this->ownerIcType,
                'bank_name' => $this->bankName,
                'bank_account_number' => $this->bankAccountNumber,
                'bank_account_name' => $this->bankAccountName,
                'bank_branch' => $this->bankBranch,
            ]);
        } else {
            $rules = [
                'fullName' => 'required|string|max:255',
                'businessName' => 'required|string|max:255',
                'businessType' => 'required|string|in:sole_proprietor,sdn_bhd,berhad,limited_liability_partnership',
                'ssmNumber' => 'required|string|max:50',
                'phone' => 'required|string|max:30',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'registeredAddress' => 'required|string|max:500',
                'registeredCity' => 'required|string|max:50',
                'registeredPostcode' => 'required|string|max:10',
                'registeredStateId' => 'required|integer|exists:states,id',
                'website' => 'nullable|url|max:255',
                'profilePicture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'ssmCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'ownerIcNumber' => 'required|string|max:50',
                'ownerIcType' => 'required|string|in:nric,passport',
                'identityDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'bankName' => 'nullable|string|max:100',
                'bankAccountNumber' => 'nullable|string|max:50',
                'bankAccountName' => 'nullable|string|max:255',
                'bankBranch' => 'nullable|string|max:255',
                'bankStatement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ];
            $this->validate($rules);

            $user->update(['name' => $this->fullName, 'email' => $this->email]);
            $owner->update([
                'business_name' => $this->businessName,
                'business_type' => $this->businessType,
                'ssm_number' => $this->ssmNumber,
                'phone' => $this->phone,
                'registered_address' => $this->registeredAddress,
                'registered_city' => $this->registeredCity,
                'registered_postcode' => $this->registeredPostcode,
                'registered_state' => optional(State::query()->find($this->registeredStateId))->name,
                'website' => $this->website ?: null,
                'identity_number' => $this->ownerIcNumber,
                'identity_document_type' => $this->ownerIcType,
                'bank_name' => $this->bankName,
                'bank_account_number' => $this->bankAccountNumber,
                'bank_account_name' => $this->bankAccountName,
                'bank_branch' => $this->bankBranch,
            ]);
        }

        if ($this->profilePicture && ! $this->isFirstTime) {
            $path = $this->profilePicture->store("owner_documents/{$user->id}/profile", 'public');
            $owner->update(['profile_picture' => $path]);
        }

        if ($this->ssmCertificate && ! $this->isFirstTime) {
            $path = $this->ssmCertificate->store("owner_documents/{$user->id}/ssm", 'public');
            $owner->update(['ssm_document' => $path]);
        }

        if ($this->identityDocument) {
            $path = $this->identityDocument->store("owner_documents/{$user->id}/identity", 'public');
            $owner->update(['identity_document' => $path]);
        }

        if ($this->bankStatement) {
            $path = $this->bankStatement->store("owner_documents/{$user->id}/bank", 'public');
            $owner->update([
                'bank_statement' => [
                    'path' => $path,
                    'uploaded_at' => now()->toDateTimeString(),
                ],
            ]);
        }

        if ($this->isFirstTime) {
            $user->forceFill(['first_time' => 1])->save();
            $this->isFirstTime = false;

            $this->reset('profilePicture', 'ssmCertificate', 'identityDocument', 'bankStatement');
            $this->saved = true;

            return $this->redirectRoute('owner.dashboard');
        }

        $this->isEditing = false;
        $this->reset('profilePicture', 'ssmCertificate', 'identityDocument', 'bankStatement');
        $this->saved = true;
    }

    public function getKycStatusProperty(): ?string
    {
        $owner = Auth::user()?->owner;
        if (! $owner) {
            return null;
        }
        $kyc = $owner->kycAccounts()->latest()->first();

        return $kyc?->kyc_status?->label();
    }

    public function getIsVerifiedProperty(): bool
    {
        $owner = Auth::user()?->owner;
        if (! $owner) {
            return false;
        }
        $kyc = $owner->kycAccounts()->latest()->first();

        return $kyc?->kyc_status?->value === 'approved';
    }

    public function getInitialsProperty(): string
    {
        $name = $this->businessName ?: 'Owner';
        $words = array_filter(explode(' ', $name));

        return strtoupper(
            count($words) >= 2
                ? mb_substr($words[0], 0, 1).mb_substr($words[1], 0, 1)
                : mb_substr($name, 0, 2)
        );
    }

    public function render(): View
    {
        return view('livewire.owner.auth.profile-page');
    }
}
