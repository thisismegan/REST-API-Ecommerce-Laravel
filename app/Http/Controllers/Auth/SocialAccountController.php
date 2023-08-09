<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SocialAccountController extends Controller
{
    public function redirectProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackProvider($provider)
    {
        if ($provider == 'twiiter') {
            $userProvider = Socialite::driver($provider)->user();
        } else {
            $userProvider = Socialite::driver($provider)->stateless()->user();
        }

        //get photo profile facebook
        $response = Http::get('https://graph.facebook.com/' . $userProvider->id . '?fields=picture&access_token=' . $userProvider->token);
        $avatar = json_decode($response->body());

        $findUser = User::where('email', $userProvider->getEmail())->first();


        if ($findUser) {

            // checkProvider
            $checkProvider  = SocialAccount::where('user_id', $findUser->id)->where('provider', $provider)->first();
            if (!$checkProvider) {
                return redirect('/')->with('failed', 'Email has been taken');
            }

            Auth::login($findUser);
            return redirect()->intended('dashboard');
        } else {
            $user = User::create([
                'name'      => $userProvider->getName(),
                'email'     => $userProvider->getEmail(),
                'password'  => encrypt(' '),
                'token'         => $userProvider->token,
                'refresh_token' => $userProvider->refreshToken ? $userProvider->refreshToken : null,
                'avatar'    => $provider == 'facebook' ? $avatar->picture->data->url : $userProvider->getAvatar()
            ]);

            SocialAccount::create([
                'user_id'       => $user->id,
                'account_id'    => $userProvider->getId(),
                'account_name'  => $userProvider->getName(),
                'provider'      => $provider,
            ]);

            Auth::login($user);

            return redirect()->intended('dashboard');
        }
    }
}
