 <x-guest-layout>
     <x-alert-failed :failed="session('failed')" />
     <x-alert-success :success="session('success')" />
     <form method="POST" action="{{ route('store.login') }}">
         @csrf
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="email" name="email" id="floating_email" placeholder="" />
             <x-input-label for="floating_email" :value="_('Email')" />
             <x-input-error :messages="$errors->get('email')" />
         </div>
         <div class="relative z-0 w-full mb-6 group">
             <x-text-input type="password" name="password" id="floating_password" placeholder="" />
             <x-input-label for="floating_password" :value="_('Password')" />
             <x-input-error :messages="$errors->get('password')" />
         </div>
         <div class="flex justify-end mb-2 text-blue-500">
             <a class="text-xs" href="register">Forgot your password?</a>
         </div>
         <div class="flex justify-end mb-2">
             <x-button>Login</x-button>
         </div>
     </form>
     <div class="inline-flex items-center justify-center w-full">
         <hr class="w-64 h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
         <span
             class="absolute px-3 font-semibold text-xs text-gray-900 -translate-x-1/2 bg-white left-1/2 dark:text-white dark:bg-gray-900">Login/Register
             with</span>
     </div>
     <div class="flex justify-center">
         <a href="{{ route('auth.redirect', 'google') }}">
             <img src="{{ asset('storage/assets/images/google.png') }}"
                 class="h-8 mr-2 hover:bg-gray-400 hover:rounded-full">
         </a>
         <a href="{{ route('auth.redirect', 'facebook') }}">
             <img src="{{ asset('storage/assets/images/facebook.png') }}"
                 class="h-8 mr-2 hover:bg-gray-400 hover:rounded-full">
         </a>
         <a href="{{ route('auth.redirect', 'twitter') }}">
             <img src="{{ asset('storage/assets/images/twitter.png') }}"
                 class="h-8 mr-2 hover:bg-gray-400 hover:rounded-full">
         </a>
         <a href="{{ route('redirect.tiktok') }}">
             <img src="{{ asset('storage/assets/images/tiktok.png') }}"
                 class="h-8 mr-2 hover:bg-gray-400 hover:rounded-full">
         </a>
     </div>
     <div class="flex justify-center mt-4">
         <h4 class="text-sm"> Don't have an account?
             <a href="{{ route('create.register') }}">
                 <span class="text-blue-500 font-semibold">Sign Up</span>
             </a>
         </h4>
     </div>
 </x-guest-layout>
