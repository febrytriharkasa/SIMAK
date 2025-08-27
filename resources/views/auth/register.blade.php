<x-guest-layout>
    <div class="min-h-screen flex justify-center items-start bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 px-4 pt-20">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-6 -mt-4">
                <img src="{{ asset('download.png') }}" 
                     alt="Logo" 
                     class="w-28 h-28 object-contain">
            </div>
            
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Create an Account</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                    <x-text-input id="name"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Role -->
                <<select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="guru_tk">Guru TK</option>
                    <option value="guru_mi">Guru MI</option>
                </select>

                <!-- Register Button -->
                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-700 transition">
                    {{ __('Register') }}
                </x-primary-button>
            </form>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="mx-2 text-gray-500 text-sm">OR</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <span class="text-sm text-gray-600">{{ __("Already have an account?") }}</span>
                <a href="{{ route('login') }}"
                    class="ml-2 text-sm font-semibold text-indigo-600 hover:underline">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
