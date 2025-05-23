<x-guest-layout>
    <!-- Navigation Bar -->
    <nav class="flex justify-between items-center p-3 mb-3 bg-gray-800 text-white">
        <div class="flex space-x-4">
            <a href="{{ route('login') }}"
                class="rounded-md px-3 py-2 transition hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300">
                Log in
            </a>
            <a href="{{ route('register') }}"
                class="rounded-md px-3 py-2 transition hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300">
                Register
            </a>
        </div>
    </nav>
    <!-- Main Container -->
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="text-center text-2xl font-bold mb-4">Login to Your Account</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full border rounded-md focus:ring focus:ring-indigo-200"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full border rounded-md focus:ring focus:ring-indigo-200"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>