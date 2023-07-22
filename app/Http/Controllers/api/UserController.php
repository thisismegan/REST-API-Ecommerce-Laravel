<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    use HttpResponses;

    public function index()
    {
        if (Auth::user()->role_id == 2) {
            $user = User::where('id', Auth::user()->id)->first();
        } else {
            $user = UserResource::collection(User::all());
        }

        return $this->success($user, 'ok', 200);
    }


    public function show($id)
    {
        if (Auth::user()->role_id == 1) {
            $user = User::where('id', $id)->first();
            return $this->success($user, 'ok', 200);
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            return $this->success($user, 'Account Information', 200);
        }
    }


    public function update(Request $request, User $user)
    {
        if (Auth::user()->id !== $user->id) {
            return $this->failed('', "Access Denied!", 401);
        }

        if ($request->hasFile('userImage')) {
            $file = $request->file('userImage');
            $name = explode('.', $file->hashName())[0];
            $extension = strtolower($file->getClientOriginalExtension());
            $image = $name . "." . $extension;


            $file->storeAs('public/user', $image); //upload image profile

            $old_imageUser = $user['userImage'];

            if ($old_imageUser != 'default.png') {
                Storage::delete('public/user/' . $old_imageUser);
            }

            $user->userImage = $image;
            $user->save();

            return $this->success('', 'Successfully', 201);
        }

        $validator = Validator::make($request->all(), [
            'firstName'     => 'required|max:15',
            'lastName'      => 'required|max:15',
            'gender'        => 'required',
        ]);

        if ($validator->fails()) {
            return $this->failed('', $validator->errors(), 401);
        }

        $user->update([
            'firstName'     => $request->firstName,
            'lastName'      => $request->lastName,
            'gender'        => $request->gender,
        ]);

        return $this->success($user, 'Successfully', 201);
    }


    public function destroy(User $user)
    {
        if (Auth::user()->id != $user->id) {
            return $this->failed('', 'You are not authorized this request', 401);
        }

        if ($user->userImage != 'default.png') {
            Storage::delete('public/user/' . $user->userImage);
        }

        Address::where('user_id', $user->id)->delete(); //Delete Address relation on user

        $user->delete(); //delete user

        return $this->success('', 'User has been deleted', 200);
    }
}
