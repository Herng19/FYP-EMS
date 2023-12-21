<x-guest-layout>
    <div class="relative">
        <div class="w-[496px] h-[863px] bg-primary-700 fixed -translate-y-1/2 translate-x-40 rotate-[59deg] rounded-[40px]"></div>
        <div class="w-[496px] h-[863px] bg-primary-700 fixed translate-y-[300px] translate-x-[990px] rotate-[59deg] rounded-[40px]"></div>
    </div>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex justify-around items-center pt-6 px-8">
                <img src="{{asset('img/umpsa_logo-removebg-preview.png')}}" alt="umpsa-logo" class="w-24 h-18">
                <img src="{{asset('img/FK_logo-removebg.png')}}" alt="FK-logo" class="w-20 h-20">
                <a href="/">
                    <img src="{{asset('img/logo.png')}}" alt="logo" class="w-20 h-20">
                </a>
            </div>
        </x-slot>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Login phrase word --}}
        <div class="my-10">
            <div class="flex my-2 items-center">
                <div class="border-4 border-primary-700 rounded-full bg-primary-700 h-8 w-2"></div>
                <div class="text-4xl font-bold text-primary-700 ml-2">Login</div>
            </div>
            <div class="text-sm text-gray-400 font-semibold">Login with your email and password. </div>
        </div>

        <x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="relative mt-4 w-full items-center text-primary-300 focus-within:text-primary-700">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                  <i class="fa-regular fa-envelope text-inherit"></i>
                </span>
                <x-input id="email" class="block mt-1 w-full pl-12" type="email" name="email" placeholder="Email" :value="old('email')" required/>
            </div>

            <div class="relative mt-4 w-full items-center text-primary-300 focus-within:text-primary-700">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <i class="fa-regular fa-lock text-inherit"></i>
                </span>
                <x-input id="password" class="block mt-1 w-full pl-12" type="password" name="password" placeholder="Password" required/>
            </div>

            <div class="mt-4">
                <select id="role" name="role" class="block mt-1 w-full bg-primary-50 text-primary-300 px-4 py-2 border border-slate-200 focus:ring-primary-400 focus:border-0 rounded-md" required>
                    <option value="" selected disabled>Role</option>
                    <option value="student" class="text-primary-700">Student</option>
                    <option value="lecturer" class="text-primary-700">Lecturer</option>
                </select>
            </div>

            <div class="block mt-4 flex justify-end">
                {{-- <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label> --}}

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-primary-700 hover:text-primary-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('password.request') }}">
                        {{ __('Forgot password') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-8 mb-4 w-full">
                <x-button class="w-full justify-center py-2">
                    {{ __('login') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
