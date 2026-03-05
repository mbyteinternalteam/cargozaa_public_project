<?php

namespace App\Http\Controllers;

use App\Enums\KYCAction;
use App\Enums\KYCStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerLoginController extends Controller
{
    public function show(): View
    {
        return view('owner.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->user_type !== UserType::OWNER) {
            return $this->logoutWithBlock($request, [
                'type' => 'not_owner',
                'title' => 'Wrong account type',
                'message' => 'This portal is only for container owners. Please use an owner account to sign in.',
            ]);
        }

        if (in_array($user->status, [UserStatus::TemporarySuspended, UserStatus::Suspended], true)) {
            return $this->logoutWithBlock($request, [
                'type' => 'status',
                'title' => $user->status->label(),
                'message' => $user->status->message(),
            ]);
        }

        $owner = $user->owner;

        if (! $owner) {
            return $this->logoutWithBlock($request, [
                'type' => 'no_owner',
                'title' => 'Owner account not found',
                'message' => 'We could not find an owner profile for this account. Please register as an owner.',
            ]);
        }

        $latestKyc = $owner->kycAccounts()->latest()->first();

        if ($latestKyc && $latestKyc->action === KYCAction::Create) {
            $blockedStatuses = [
                KYCStatus::Pending,
                KYCStatus::UnderReview,
                KYCStatus::Rejected,
                KYCStatus::Suspended,
            ];

            if (in_array($latestKyc->kyc_status, $blockedStatuses, true)) {
                $payload = [
                    'type' => 'kyc',
                    'title' => $latestKyc->kyc_status->label(),
                    'message' => $latestKyc->kyc_status->message(),
                ];

                if (in_array($latestKyc->kyc_status, [KYCStatus::Rejected, KYCStatus::Suspended], true)) {
                    $payload['reason'] = $latestKyc->rejection_reason;
                    $payload['details'] = $latestKyc->rejection_details;
                }

                return $this->logoutWithBlock($request, $payload);
            }
        }

        if ((int) ($user->first_time ?? 0) === 0) {
            return redirect()->route('owner.profile');
        }

        return redirect()->route('owner.dashboard');
    }

    /**
     * Log the user out and send them back to the login page with a modal payload.
     *
     * @param  array<string, mixed>  $payload
     */
    protected function logoutWithBlock(Request $request, array $payload): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('owner.login')
            ->with('owner_login_blocked', $payload);
    }
}
