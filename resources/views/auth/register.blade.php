 <x-guest-layout>
     <form method="POST" action="{{ route('store.register') }}">
         @csrf
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="text" name="name" id="floating_name" :value="old('name')" placeholder="" />
             <x-input-label for="floating_name" :value="_('Nama')" />
             <x-input-error :messages="$errors->get('name')" />
         </div>
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="email" name="email" id="floating_email" :value="old('email')" placeholder="" />
             <x-input-label for="floating_email" :value="_('Email')" />
             <x-input-error :messages="$errors->get('email')" />
         </div>
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="password" name="password" id="floating_password" placeholder="" />
             <x-input-label for="floating_password" :value="_('Kata Sandi')" />
             <x-input-error :messages="$errors->get('password')" />
         </div>
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="password" name="password_confirmation" id="floating_password" placeholder="" />
             <x-input-label for="floating_password" :value="_('Konfirmasi Kata Sandi')" />
         </div>
         <div class="flex justify-end mb-2">
             <x-button>Register</x-button>
         </div>
     </form>
     <div class="flex justify-center mt-4">
         <h4 class="text-sm">Have an account?<a href="{{ route('create.login') }}"> <span
                     class="text-blue-500 font-semibold">Sign
                     In</span></a>
         </h4>
     </div>
 </x-guest-layout>
