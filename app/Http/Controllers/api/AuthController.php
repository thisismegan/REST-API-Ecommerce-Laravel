<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailVerify;
use App\Mail\SendPasswordReset;
use App\Models\PasswordReset;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->validated($request->all());

        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->email_verified_at == NULL) {
                return $this->failed('', 'Your account not activate', 401);
            } else {

                $user = User::where('email', $request->email)->first();

                return $this->success([
                    'user'  => $user,
                    'token' => $user->createToken('API TOKEN:' . $user->name)->plainTextToken
                ], 'You are authenticated now!', 200);
            }
        } else {
            return $this->failed('', 'Credentials do not match', 401);
        }
    }


    public function register(RegisterUserRequest $request)
    {

        $request->validated($request->all());

        // input data to users table
        $user = User::create([
            'role_id'       => 2,
            'firstName'     => $request->firstName,
            'lastName'      => $request->lastName,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'userImage'     => "default.png",
        ]);


        $token = Str::random(80);

        // input data to users_verify table
        UserVerify::create([
            'user_id' => $user->id,
            'token'   => $token
        ]);

        // sent mail verification link
        Mail::to($request->email)->send(new MailVerify($token));

        return $this->success([
            'user'    => $user,
            'token'   => $user->createToken('API Token: ' . $user->firstName)->plainTextToken
        ], 'Please activate your account before login. Check your email', 201);
    }


    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->where('tokenable_id', $user->id)->delete();

        return $this->success('', 'ok', 200);
    }

    public function mailActivation($token)
    {

        $userVerify = UserVerify::where('token', $token)->first();

        if (!is_null($userVerify)) {
            $user = $userVerify->user;
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                $userVerify->where('user_id', $user->id)->delete();

                return $this->success('', 'Your email is Verified', 200);
            } else {
                return $this->success('', 'Your email is already Verified', 200);
            }
        }

        return $this->failed('', 'Email is not registered', 500);
    }

    public function forgotPassword(Request $request)
    {
        //validate email request
        $request->validate([
            'email' => 'required|email'
        ]);


        //check email is registered
        $user = User::where('email', $request->email)->first();

        if ($user) {
            //delete old token if exist
            PasswordReset::where('email', $user->email)->delete();

            //create token
            $token = Str::random(80);

            //input data reset password
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Date('Y-m-d H:i:s')
            ]);


            // sent mail reset password link
            Mail::to($request->email)->send(new SendPasswordReset($request->email, $token));

            return $this->success('', 'link sent to your email', 200);
        }

        return $this->failed('', 'Your email is not registered', 401);
    }

    public function checkToken($email, $token)
    {
        $passwordReset =  PasswordReset::where('token', $token)->first();

        if ($passwordReset) {
            return $this->success($token, 'Token is valid', 201);
        }

        return $this->failed('', 'Token is expired', 401);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'         => 'required',
            'email'         => 'required|email',
            'password'      => 'required|min:8|confirmed'
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)->first();

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        //delete token on table password_resets
        PasswordReset::where('email', $user->email)->delete();

        return $this->success('', 'Success reset password', 200);
    }
}
