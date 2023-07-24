<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


trait HttpResponses
{

    protected function success($data, $message = null, $code = null)
    {
        return response()->json([
            'status'  => $code,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function failed($data = null, $message = null, $code = null)
    {
        return response()->json([
            'status'  => $code,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function isAdmin()
    {
        if (Auth::user()->role_id == 1) {
            $user = User::all();
            return $this->success($user, 'Access Granted!');
        }

        return $this->failed('', "Access Denied!", 401);
    }

    protected function userAccess($request)
    {
        if (Auth::id() !== $request) {
            return $this->failed('', "Access Denied!", 401);
        }
    }
}
