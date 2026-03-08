<?php

namespace App\Livewire\Customer;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SignupForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $fullName = '';

    #[Validate('required|email:rfc,dns|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|max:30')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $companyName = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|string|min:8|same:password')]
    public string $passwordConfirmation = '';

    #[Validate('accepted')]
    public bool $acceptTerms = false;

    public bool $showPassword = false;

    public function submit(): void
    {
        $this->validate();

        DB::transaction(function (): void {
            $user = User::query()->create([
                'name' => $this->fullName,
                'email' => $this->email,
                'password' => $this->password,
                'user_type' => UserType::CUSTOMER,
                'status' => UserStatus::Active,
            ]);

            Customer::query()->create([
                'user_id' => $user->id,
                'phone' => $this->phone,
                'company_name' => $this->companyName,
            ]);
        });

        session()->flash('customer_signup_success', true);

        $this->redirectRoute('customer.login');
    }

    public function render()
    {
        return view('livewire.customer.signup-form');
    }
}
