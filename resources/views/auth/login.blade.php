<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ __('Giriş Yap') }}</h1>
        <p class="text-sm text-gray-600 dark:text-emerald-100">{{ __('LingoBox hesabınıza giriş yapın') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="email" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Şifre')" class="text-gray-700 dark:text-emerald-200" />

            <x-text-input id="password" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-emerald-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-emerald-200">{{ __('Beni hatırla') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 mb-3 sm:mb-0" href="{{ route('password.request') }}">
                    {{ __('Şifrenizi mi unuttunuz?') }}
                </a>
            @endif

            <div class="w-full sm:w-auto">
                <x-primary-button class="w-full justify-center">
                    {{ __('Giriş Yap') }}
                </x-primary-button>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200">
                {{ __('Henüz hesabınız yok mu? Kayıt olun') }}
            </a>
        </div>
    </form>
</x-guest-layout>
