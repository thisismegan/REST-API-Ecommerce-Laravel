<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiktokLoginController extends Controller
{

    public function redirect()
    {
        $clientKey = 'awcxkm3o916hhzkn';
        $uriCallback = 'https://f0a7-114-79-49-224.ngrok-free.app/callback/tiktok';
        $csrfToken = Str::random(60);

        return redirect()->to("https://www.tiktok.com/v2/auth/authorize/?client_key=" . $clientKey . "&response_type=code&scope=user.info.basic&redirect_uri=" . $uriCallback . "&state=" . $csrfToken);
    }

    public function callback(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data'   => $request->all()
        ], 200);
    }
}
