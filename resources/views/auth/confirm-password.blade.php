<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ __('Şifre Doğrulama') }}</h1>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-emerald-100">
        {{ __('Bu, uygulamanın güvenli bir alanıdır. Devam etmeden önce lütfen şifrenizi doğrulayın.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Şifre')" class="text-gray-700 dark:text-emerald-200" />

            <x-text-input id="password" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Doğrula') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
