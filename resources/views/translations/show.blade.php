<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-700 dark:text-white leading-tight">
            {{ __('Kelime Detayı') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-emerald-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Kaynak Metin') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->source_text }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Hedef Metin') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->target_text }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Kaynak Dil') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->sourceLanguage->name }} ({{ $translation->sourceLanguage->code }})</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Hedef Dil') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->targetLanguage->name }} ({{ $translation->targetLanguage->code }})</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Kategori') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->category ?? __('Belirtilmemiş') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Örnek Cümle') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->example_sentence ?? __('Yok') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Eklenme Tarihi') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-emerald-600 dark:text-white">{{ __('Son Güncelleme') }}</h3>
                            <p class="mt-1 text-sm text-emerald-800 dark:text-emerald-100">{{ $translation->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('translations.index') }}" class="w-full sm:w-auto">
                            <x-secondary-button class="w-full justify-center dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:text-white">
                                {{ __('Listeye Dön') }}
                            </x-secondary-button>
                        </a>
                        <div class="flex space-x-4 w-full sm:w-auto">
                            <a href="{{ route('translations.edit', $translation) }}" class="w-full sm:w-auto">
                                <x-primary-button class="w-full justify-center">
                                    <x-heroicon-o-pencil class="w-5 h-5 mr-2"/>
                                    {{ __('Düzenle') }}
                                </x-primary-button>
                            </a>
                            <form action="{{ route('translations.destroy', $translation) }}" method="POST" class="inline w-full sm:w-auto" onsubmit="return confirm('{{ __('Bu çeviriyi silmek istediğinizden emin misiniz?') }}');">
                                @csrf
                                @method('DELETE')
                                <x-primary-button type="submit" class="w-full justify-center bg-emerald-600 hover:bg-emerald-500 dark:bg-emerald-600 dark:hover:bg-emerald-500 focus:ring-emerald-500">
                                    <x-heroicon-o-trash class="w-5 h-5 mr-2"/>
                                    {{ __('Sil') }}
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 