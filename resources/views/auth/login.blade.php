@section('title', 'Selamat Datang')

<x-guest-layout>
    <div class="min-h-screen flex justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 px-4 pt-10">

        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6 -mt-4">
                <img src="{{ asset('download.png') }}" 
                     alt="Logo" 
                     class="w-28 h-28 object-contain">
            </div>

            <!-- Judul -->
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Login to Your Account</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="email" name="email" :value="old('email')" required autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center space-x-2">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            name="remember">
                        <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-700 transition">
                    {{ __('Log in') }}
                </x-primary-button>
            </form>

            <!-- Divider 
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="mx-2 text-gray-500 text-sm">OR</span>
                <hr class="flex-grow border-gray-300">
            </div> -->

            <!-- Register Link 
            <div class="text-center">
                <span class="text-sm text-gray-600">{{ __("Don't have an account?") }}</span>
                <a href="{{ route('register') }}"
                    class="ml-2 text-sm font-semibold text-green-600 hover:underline">
                    {{ __('Register') }}
                </a>
            </div> -->
        </div>
    </div>
</x-guest-layout>
