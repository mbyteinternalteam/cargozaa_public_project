<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOwnerIsActive
{
    /**
     * Handle an incoming request.
     * Only allows ACTIVE owners (not pending users) to access specific routes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return $next($request);
        }
        
        // Check if user is active and has correct User Type for owner routes
        if ($user->user_type == UserType::OWNER) {

            if ($user->status !== UserStatus::Active) {
                // If user is not active, show popup using login modal system
                return redirect()->route('owner.profile')
                    ->with('owner_login_blocked', [
                        'title' => 'Account Pending',
                        'message' => 'Your account doesn\'t have access to this page yet. Please contact support to activate your account.',
                        'reason' => 'Account status is pending'
                    ]);
            }
            
        }
        return $next($request);
    }
}
