<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ __('Şifremi Unuttum') }}</h1>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-emerald-100">
        {{ __('Şifrenizi mi unuttunuz? Sorun değil. Sadece e-posta adresinizi girin, size yeni bir şifre belirlemenizi sağlayacak bir sıfırlama bağlantısı göndereceğiz.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-emerald-200" />
            <x-text-input id="email" class="block mt-1 w-full border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 mb-3 sm:mb-0">
                {{ __('Giriş sayfasına dön') }}
            </a>
            
            <div class="w-full sm:w-auto">
                <x-primary-button class="w-full justify-center">
                    {{ __('Şifre Sıfırlama Bağlantısı Gönder') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
