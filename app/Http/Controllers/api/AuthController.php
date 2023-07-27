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
use Illuminate\Support\Facades\Password as ForgotPassword;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Auth\Events\PasswordReset as EventsPasswordReset;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credentials do not match.'],
            ]);
        }

        $token = $user->createToken('API TOKEN:' . $user->firstName)    ->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'User', 200);
    }


    public function register(RegisterUserRequest $request)
    {

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

        return $this->failed('', 'Token is expired', 500);
    }

    public function changePassword(ChangePasswordRequest $request)
    {

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return $this->failed('', 'Kata Sandi yang anda masukkan salah', 401);
        }

        $user = User::find(Auth::id());

        $user->password = Hash::make($request->password);
        $user->save();

        return $this->success('', 'Kata sandi berhasil diubah', 200);
    }


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = ForgotPassword::sendResetLink(
            $request->only('email')
        );
        return $status === ForgotPassword::RESET_LINK_SENT
            ? $this->success('', 'Link reset password telah dikirim', 200)
            : $this->failed('', 'Email tidak terdaftar', 401);
    }

    public function resetPassword($token)
    {
        return redirect('http://localhost:5173/resetpassword/' . $token);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $status = ForgotPassword::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new EventsPasswordReset($user));
            }
        );

        return $status === ForgotPassword::PASSWORD_RESET
            ? $this->success('', 'Berhasil perbaharui Kata Sandi', 201)
            : $this->failed('', 'Email tidak terdaftar', 401);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return $this->success('', 'ok', 200);
    }
}
