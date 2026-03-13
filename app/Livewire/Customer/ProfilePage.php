<?php

namespace App\Livewire\Customer;

use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('shared.layouts.app')]
class ProfilePage extends Component
{
    use WithFileUploads;

    public bool $isEditing = false;

    public bool $saved = false;

    public string $activeTab = 'personal';

    #[Validate('required|string|max:255')]
    public string $fullName = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('nullable|string|max:30')]
    public ?string $phone = '';

    #[Validate('nullable|string|max:255')]
    public ?string $companyName = '';

    #[Validate('nullable|string|max:500')]
    public ?string $billingAddress = '';

    #[Validate('nullable|string|max:100')]
    public ?string $billingCity = '';

    #[Validate('nullable|integer|exists:states,id')]
    public int|string|null $billingStateId = '';

    #[Validate('nullable|string|max:10')]
    public ?string $billingPostcode = '';

    /** @var \Illuminate\Http\UploadedFile|null */
    public $profilePicture = null;

    public function mount(): void
    {
        $user = Auth::user();
        if (! $user || $user->user_type !== UserType::CUSTOMER) {
            $this->redirectRoute('login');

            return;
        }

        $this->fillFromUser($user);
    }

    protected function fillFromUser($user): void
    {
        $customer = $user->customer;
        $this->fullName = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $customer?->phone ?? '';
        $this->companyName = $customer?->company_name ?? '';
        $this->billingAddress = $customer?->billing_address ?? '';
        $this->billingCity = $customer?->billing_city ?? '';
        $this->billingStateId = $customer?->billing_state ?? '';
        $this->billingPostcode = $customer?->billing_postcode ?? '';
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = in_array($tab, ['personal', 'settings', 'activity'], true) ? $tab : 'personal';
    }

    public function edit(): void
    {
        $this->isEditing = true;
        $this->saved = false;
    }

    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->fillFromUser(Auth::user());
        $this->reset('profilePicture');
        $this->resetValidation();
    }

    public function updatedProfilePicture(): void
    {
        $this->validate(['profilePicture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048']);
        $user = Auth::user();
        $customer = $user?->customer;
        if ($customer && $this->profilePicture) {
            $path = $this->profilePicture->store("customer_documents/{$user->id}/profile", 'public');
            $customer->update(['profile_picture' => $path]);
            $this->reset('profilePicture');
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->update(['name' => $this->fullName, 'email' => $this->email]);

        $customer = $user->customer;
        if ($customer) {
            $customer->update([
                'phone' => $this->phone ?: null,
                'company_name' => $this->companyName ?: null,
                'billing_address' => $this->billingAddress ?: null,
                'billing_city' => $this->billingCity ?: null,
                'billing_state' => $this->billingStateId ?: null,
                'billing_postcode' => $this->billingPostcode ?: null,
            ]);
        }

        if ($this->profilePicture) {
            $path = $this->profilePicture->store("customer_documents/{$user->id}/profile", 'public');
            $customer?->update(['profile_picture' => $path]);
        }

        $this->isEditing = false;
        $this->reset('profilePicture');
        $this->saved = true;
    }

    public function getProfilePictureUrlProperty(): ?string
    {
        $customer = Auth::user()?->customer;

        return $customer?->profile_picture ? Storage::url($customer->profile_picture) : null;
    }

    public function getInitialsProperty(): string
    {
        $name = $this->fullName ?: 'Customer';
        $words = array_filter(explode(' ', $name));

        return strtoupper(
            count($words) >= 2
                ? mb_substr($words[0], 0, 1).mb_substr($words[1], 0, 1)
                : mb_substr($name, 0, 2)
        );
    }

    public function getMemberSinceProperty(): string
    {
        return Auth::user()?->created_at?->format('M Y') ?? '—';
    }

    public function getIsVerifiedProperty(): bool
    {
        return Auth::user()?->email_verified_at !== null;
    }

    public function render(): View
    {
        return view('livewire.customer.profile-page');
    }
}
