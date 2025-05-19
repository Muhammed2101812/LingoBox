<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Çeviri Ekle') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-card>
                <div class="p-6">
                    
                    {{-- Session Messages and Validation Errors --}}
                    <div class="mb-6">
                        @if (session('success'))
                            <div class="p-4 mb-4 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200" role="alert">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span><span class="font-medium">{{ __('Başarılı!') }}</span> {{ session('success') }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($errors->any() && !session('success') && !session('error'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200" role="alert">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span><span class="font-medium">{{ __('Hata!') }}</span> {{ __('Lütfen formdaki hataları düzeltin.') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('translations.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <!-- Kaynak Metin -->
                                <div class="mb-4">
                                    <x-input-label for="source_text" :value="__('Kaynak Metin')" />
                                    <textarea id="source_text" name="source_text" rows="3" class="block mt-1 w-full border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm resize-none" required autofocus>{{ old('source_text') }}</textarea>
                                    <x-input-error :messages="$errors->get('source_text')" class="mt-2" />
                                </div>

                                <!-- Kaynak Dil -->
                                <div class="mb-4">
                                    <x-input-label for="source_lang_id" :value="__('Kaynak Dil')" />
                                    <select id="source_lang_id" name="source_lang_id" class="block mt-1 w-full border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm" required>
                                        <option value="">{{ __('Dil Seçiniz') }}</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('source_lang_id') == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }} ({{ $language->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('source_lang_id')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <!-- Hedef Metin -->
                                <div class="mb-4">
                                    <x-input-label for="target_text" :value="__('Hedef Metin')" />
                                    <textarea id="target_text" name="target_text" rows="3" class="block mt-1 w-full border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm resize-none" required>{{ old('target_text') }}</textarea>
                                    <x-input-error :messages="$errors->get('target_text')" class="mt-2" />
                                </div>

                                <!-- Hedef Dil -->
                                <div class="mb-4">
                                    <x-input-label for="target_lang_id" :value="__('Hedef Dil')" />
                                    <select id="target_lang_id" name="target_lang_id" class="block mt-1 w-full border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm" required>
                                        <option value="">{{ __('Dil Seçiniz') }}</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('target_lang_id') == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }} ({{ $language->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('target_lang_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4 mt-2">
                            <x-input-label for="category" :value="__('Kategori (Opsiyonel)')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category')" placeholder="Örn: İş Kelimeler, Seyahat, Yemek vb." />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Örnek Cümle -->
                        <div class="mb-6">
                            <x-input-label for="example_sentence" :value="__('Örnek Cümle (Opsiyonel)')" />
                            <textarea id="example_sentence" name="example_sentence" rows="2" class="block mt-1 w-full border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm" placeholder="Bu kelimeyi içeren bir örnek cümle yazabilirsiniz.">{{ old('example_sentence') }}</textarea>
                            <x-input-error :messages="$errors->get('example_sentence')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('translations.index') }}" class="text-gray-500 mr-4 hover:text-gray-700">
                                {{ __('İptal') }}
                            </a>
                            <x-primary-button type="submit">
                                {{ __('Kaydet') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 