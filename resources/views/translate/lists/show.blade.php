<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight mb-4 sm:mb-0 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                {{ $list->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('translate.lists.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    {{ __('Listelerime Dön') }}
                </a>
                <a href="{{ route('translate.index') }}?list_id={{ $list->id }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('Yeni Kelime Ekle') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($list->description)
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-700/30 rounded-lg text-gray-700 dark:text-emerald-200">
                    {{ $list->description }}
                </div>
            @endif
            
            <!-- Liste İstatistikleri -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-4 mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center p-4">
                    <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                        {{ $list->translations->count() }}
                    </span>
                    <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Toplam Kelime') }}</span>
                </div>
                
                <div class="text-center p-4 border-l border-r border-gray-200 dark:border-emerald-600/30">
                    <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                        {{ $list->translations->pluck('category')->unique()->count() }}
                    </span>
                    <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Farklı Kategori') }}</span>
                </div>
                
                <div class="text-center p-4">
                    <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                        {{ $list->created_at->format('d.m.Y') }}
                    </span>
                    <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Oluşturulma Tarihi') }}</span>
                </div>
            </div>

            @if($list->translations->isEmpty())
                <x-card>
                    <div class="py-12 px-6 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('Bu listede henüz hiç kelime yok') }}</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-300">{{ __('Çeviri aracını kullanarak bu listeye kelimeler ekleyin.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('translate.index') }}?list_id={{ $list->id }}" class="inline-flex items-center px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('Kelime Ekle') }}
                            </a>
                        </div>
                    </div>
                </x-card>
            @else
                <!-- Kategori Filtreleri -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2">
                        <button id="category-all" class="px-3 py-1 bg-custom-green text-white text-sm font-medium rounded-full">
                            {{ __('Tümü') }}
                        </button>
                        @foreach($list->translations->pluck('category')->unique() as $category)
                            <button id="category-{{ Str::slug($category) }}" class="px-3 py-1 bg-gray-200 dark:bg-emerald-700/50 text-gray-700 dark:text-emerald-200 text-sm font-medium rounded-full hover:bg-gray-300 dark:hover:bg-emerald-700/80">
                                {{ $category }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Kelime Kartları -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($list->translations as $translation)
                        <x-card class="translation-card flex flex-col h-full" data-category="{{ Str::slug($translation->category) }}">
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2 break-words">
                                    {{ $translation->source_text }}
                                </h3>
                                <p class="text-lg text-gray-700 dark:text-gray-200 mb-4 break-words">
                                    {{ $translation->target_text }}
                                </p>

                                <div class="mb-4 space-y-2">
                                    <div class="flex flex-wrap items-center text-sm">
                                        <span class="font-medium text-gray-600 dark:text-gray-300 mr-2">{{ __('Kaynak:') }}</span>
                                        <span class="px-2.5 py-0.5 bg-custom-green bg-opacity-10 text-custom-green dark:bg-emerald-700/50 dark:text-emerald-200 text-xs font-medium rounded-full">
                                            {{ $translation->sourceLanguage->name }} ({{ $translation->sourceLanguage->code }})
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap items-center text-sm">
                                        <span class="font-medium text-gray-600 dark:text-gray-300 mr-2">{{ __('Hedef:') }}</span>
                                        <span class="px-2.5 py-0.5 bg-custom-green bg-opacity-10 text-custom-green dark:bg-emerald-700/50 dark:text-emerald-200 text-xs font-medium rounded-full">
                                            {{ $translation->targetLanguage->name }} ({{ $translation->targetLanguage->code }})
                                        </span>
                                    </div>
                                    @if($translation->category)
                                        <div class="flex flex-wrap items-center text-sm">
                                            <span class="font-medium text-gray-600 dark:text-gray-300 mr-2">{{ __('Kategori:') }}</span>
                                            <span class="px-2.5 py-0.5 bg-gray-100 dark:bg-emerald-700/30 text-gray-800 dark:text-gray-200 text-xs font-medium rounded-full">
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
                                        <div x-show="open" x-transition class="mt-2 p-3 bg-gray-50 dark:bg-emerald-700/20 rounded-md text-sm text-gray-700 dark:text-gray-200">
                                            <p class="italic">{{ $translation->example_sentence }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="px-6 py-3 bg-gray-50 dark:bg-emerald-700/30 border-t border-gray-100 dark:border-emerald-600/20 flex justify-between items-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $translation->created_at->format('d.m.Y') }}
                                </p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('translations.show', $translation) }}" class="text-gray-500 dark:text-gray-300 hover:text-custom-green dark:hover:text-emerald-300 transition-colors duration-200" title="{{ __('Detaylar') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('translations.edit', $translation) }}" class="text-gray-500 dark:text-gray-300 hover:text-custom-green dark:hover:text-emerald-300 transition-colors duration-200" title="{{ __('Düzenle') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L19.5 12.75l-4.243 4.243L10.5 16.5l4.243-4.243-2.828-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('translations.destroy', $translation) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Bu çeviriyi silmek istediğinizden emin misiniz?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200" title="{{ __('Sil') }}">
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
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kategori Filtreleme
            const allBtn = document.getElementById('category-all');
            const categoryBtns = document.querySelectorAll('[id^="category-"]:not(#category-all)');
            const cards = document.querySelectorAll('.translation-card');
            
            if (allBtn) {
                allBtn.addEventListener('click', function() {
                    resetCategoryButtons();
                    allBtn.classList.remove('bg-gray-200', 'dark:bg-emerald-700/50', 'text-gray-700', 'dark:text-emerald-200');
                    allBtn.classList.add('bg-custom-green', 'text-white');
                    
                    cards.forEach(card => {
                        card.classList.remove('hidden');
                    });
                });
            }
            
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.id.replace('category-', '');
                    
                    resetCategoryButtons();
                    this.classList.remove('bg-gray-200', 'dark:bg-emerald-700/50', 'text-gray-700', 'dark:text-emerald-200');
                    this.classList.add('bg-custom-green', 'text-white');
                    
                    cards.forEach(card => {
                        if (card.dataset.category === category) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });
            });
            
            function resetCategoryButtons() {
                allBtn.classList.remove('bg-custom-green', 'text-white');
                allBtn.classList.add('bg-gray-200', 'dark:bg-emerald-700/50', 'text-gray-700', 'dark:text-emerald-200');
                
                categoryBtns.forEach(btn => {
                    btn.classList.remove('bg-custom-green', 'text-white');
                    btn.classList.add('bg-gray-200', 'dark:bg-emerald-700/50', 'text-gray-700', 'dark:text-emerald-200');
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 