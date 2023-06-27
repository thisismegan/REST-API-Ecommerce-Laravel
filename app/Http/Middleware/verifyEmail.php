<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class verifyEmail
{

    public function handle(Request $request, Closure $next)
    {

        if (Auth::user()->email_verified_at == NULL) {
            return response()->json([
                'status' => 402,
                'message' => 'Your email address is not verified.'
            ]);
        }
        return $next($request);
    }
}
