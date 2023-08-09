@extends('layouts.partials.main')
@section('content')
    <div class="p-4 sm:ml-64 h-min-screen bg-gray-100 flex justify-center">
        <section class="bg-white dark:bg-gray-900 mt-16 w-3/4">
            <div class="mx-auto w-full p-8">
                <h2 class="mb-2 font-semibold text-gray-900 dark:text-white">Profile Information</h2>
                <hr class="mb-2">
                @if ($errors->any())
                    <div class="flex  w-full p-4 text-gray-500 bg-white shadow" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-xs">
                                    <span class="flex items-center text-sm font-normal text-red-600">
                                        <span class="flex w-2.5 h-2.5 bg-red-600 rounded-full mr-1.5 flex-shrink-0">
                                        </span>
                                        {{ $error }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-alert-success :success="session('success')" />
                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-input-group type="text" id="name" name="name" :value="old('name', $user->name)" for="name"
                        labelName="Name" />
                    <x-input-group type="email" id="email" name="email" :value="old('email', $user->email)" for="email"
                        labelName="Email" disabled />
                    <div class="grid grid-cols-3 gap-2 mt-3 justify-start">
                        <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Photo Profile
                        </label>
                        <img src="{{ App\Services\UserService::userImage($user->avatar) }}" class="w-20 h-20 border">
                        <input class="file:bg-red-600 file:bg-inherit h-10 items-center text-xs text-gray-900 bg-gray-50"
                            name="avatar" type="file">
                    </div>
                    <x-input-group type="country" id="country" name="country" :value="old('country', $user->country)" for="country"
                        labelName="Country" />
                    <x-input-group type="phone" id="phone" name="phone" :value="old('phone', $user->phone)" for="phone"
                        labelName="Phone" />
                    <x-input-group type="company" id="company" name="company" :value="old('company', $user->company)" for="company"
                        labelName="Company" />
                    <x-input-group type="address" id="address" name="address" :value="old('address', $user->address)" for="address"
                        labelName="Address" />
                    <x-input-group type="city" id="city" name="city" :value="old('city', $user->city)" for="city"
                        labelName="City" />
                    <div class="flex justify-end">
                        <button type="submit" class="py-1 px-1.5 mt-3 text-white rounded-sm bg-blue-500 hover:bg-blue-800">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
