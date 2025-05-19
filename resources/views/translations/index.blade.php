<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4 sm:mb-0">
                {{ __('Kelimelerim') }}
            </h2>
            <a href="{{ route('translations.create') }}">
                <x-primary-button>
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('Yeni Kelime Ekle') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span><strong class="font-semibold">{{ __('Hata:') }}</strong> {{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($translations->isEmpty())
                <x-card>
                    <div class="py-12 px-6 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('Henüz hiç kelime eklemediniz') }}</h3>
                        <p class="mt-1 text-gray-500">{{ __('Kelime ekleyerek çeviri koleksiyonunuzu oluşturmaya başlayın.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('translations.create') }}" class="inline-flex items-center px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('İlk Kelimeyi Ekle') }}
                            </a>
                        </div>
                    </div>
                </x-card>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($translations as $translation)
                        <x-card class="flex flex-col h-full">
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 break-words">
                                    {{ $translation->source_text }}
                                </h3>
                                <p class="text-lg text-gray-700 mb-4 break-words">
                                    {{ $translation->target_text }}
                                </p>

                                <div class="mb-4 space-y-2">
                                    <div class="flex flex-wrap items-center text-sm">
                                        <span class="font-medium text-gray-600 mr-2">{{ __('Kaynak:') }}</span>
                                        <span class="px-2.5 py-0.5 bg-custom-green bg-opacity-10 text-custom-green text-xs font-medium rounded-full">
                                            {{ $translation->sourceLanguage->name }} ({{ $translation->sourceLanguage->code }})
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap items-center text-sm">
                                        <span class="font-medium text-gray-600 mr-2">{{ __('Hedef:') }}</span>
                                        <span class="px-2.5 py-0.5 bg-custom-green bg-opacity-10 text-custom-green text-xs font-medium rounded-full">
                                            {{ $translation->targetLanguage->name }} ({{ $translation->targetLanguage->code }})
                                        </span>
                                    </div>
                                    @if($translation->category)
                                        <div class="flex flex-wrap items-center text-sm">
                                            <span class="font-medium text-gray-600 mr-2">{{ __('Kategori:') }}</span>
                                            <span class="px-2.5 py-0.5 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                {{ $translation->category }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                @if($translation->example_sentence)
                                    <div x-data="{ open: false }" class="mb-2">
                                        <button @click="open = !open" class="flex items-center text-sm text-custom-green hover:text-opacity-80 focus:outline-none transition-colors duration-200">
                                            <span x-show="!open">{{ __('Örnek Cümleyi Göster') }}</span>
                                            <span x-show="open">{{ __('Örnek Cümleyi Gizle') }}</span>
                                            <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="open" x-transition class="mt-2 p-3 bg-gray-50 rounded-md text-sm text-gray-700">
                                            <p class="italic">{{ $translation->example_sentence }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <p class="text-xs text-gray-500">
                                    {{ $translation->created_at->format('d.m.Y') }}
                                </p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('translations.show', $translation) }}" class="text-gray-500 hover:text-custom-green transition-colors duration-200" title="{{ __('Detaylar') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('translations.edit', $translation) }}" class="text-gray-500 hover:text-custom-green transition-colors duration-200" title="{{ __('Düzenle') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L19.5 12.75l-4.243 4.243L10.5 16.5l4.243-4.243-2.828-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('translations.destroy', $translation) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Bu çeviriyi silmek istediğinizden emin misiniz?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-500 transition-colors duration-200" title="{{ __('Sil') }}">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m6-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>

                @if ($translations->hasPages())
                    <div class="mt-6">
                        {{ $translations->links() }} 
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout> 