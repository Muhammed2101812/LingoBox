<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ __('Şifre Yenileme') }}</h1>
        <p class="text-sm text-gray-600 dark:text-emerald-100">{{ __('Lütfen yeni şifrenizi belirleyin') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="email" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Yeni Şifre')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="password" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
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

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Şifreyi Yenile') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
