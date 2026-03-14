<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->user_type !== UserType::CUSTOMER) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
