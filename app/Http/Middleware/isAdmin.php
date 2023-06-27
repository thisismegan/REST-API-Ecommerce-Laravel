<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role_id != 1) {

            return response()->json([
                'status'  => 500,
                'message' => 'Access Denied'
            ], 500);
        }
        return $next($request);
    }
}
