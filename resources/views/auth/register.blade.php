<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ __('Kayıt Ol') }}</h1>
        <p class="text-sm text-gray-600 dark:text-emerald-100">{{ __('LingoBox ailesine katılın') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Ad')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="name" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="email" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Şifre')" class="text-gray-700 dark:text-emerald-200" />

            <x-text-input id="password" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Şifre Tekrar')" class="text-gray-700 dark:text-emerald-200" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            <a class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 mb-3 sm:mb-0" href="{{ route('login') }}">
                {{ __('Zaten kayıtlı mısınız?') }}
            </a>

            <div class="w-full sm:w-auto">
                <x-primary-button class="w-full justify-center">
                    {{ __('Kayıt Ol') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
