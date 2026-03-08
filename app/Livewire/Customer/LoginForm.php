<?php

namespace App\Livewire\Customer;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LoginForm extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public bool $showPassword = false;

    public function login(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', 'These credentials do not match our records.');

            return;
        }

        request()->session()->regenerate();
        $user = Auth::user();

        if ($user->user_type !== UserType::CUSTOMER) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $this->addError('email', 'This portal is for customers. Please use a customer account to sign in.');

            return;
        }

        if (in_array($user->status, [UserStatus::TemporarySuspended, UserStatus::Suspended], true)) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $this->addError('email', $user->status->message());

            return;
        }

        $this->redirectRoute('customer.dashboard');
    }

    public function render()
    {
        return view('livewire.customer.login-form');
    }
}
