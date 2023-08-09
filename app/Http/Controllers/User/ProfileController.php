<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;

class ProfileController extends Controller
{

    public $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', ['user' => $user]);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            $imageName =  $this->userService->handleUploadImage($request->file('avatar'));
            $user->avatar = $imageName;
        }

        $user->name = $request->name;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->company = $request->company;
        $user->address = $request->address;
        $user->city = $request->city;

        $user->save();

        return redirect()->back()->with('success', __('messages.success_update'));
    }
}
