<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OwnerProfileController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        if (! auth()->check()) {
            return redirect()->route('owner.login');
        }
        if (auth()->user()->user_type !== UserType::OWNER) {
            return redirect()->route('owner.login');
        }
        if (! auth()->user()->owner) {
            return redirect()->route('owner.signup');
        }

        return view('owner.profile');
    }
}
