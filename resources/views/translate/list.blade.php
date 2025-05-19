<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight">
                {{ $list->name }}
            </h2>
            <a href="{{ route('translate.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                {{ __('Çeviri Aracına Dön') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    @if($list->description)
                        <div class="mb-4 text-gray-600 dark:text-emerald-300">
                            {{ $list->description }}
                        </div>
                    @endif
                    
                    <!-- Liste İstatistikleri -->
                    <div class="bg-emerald-50 dark:bg-emerald-700 rounded-lg p-4 mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                                {{ $list->translations->count() }}
                            </span>
                            <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Toplam Çeviri') }}</span>
                        </div>
                        
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                                {{ $list->created_at->format('d.m.Y') }}
                            </span>
                            <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Oluşturulma Tarihi') }}</span>
                        </div>
                        
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">
                                {{ $list->translations->pluck('category')->unique()->count() }}
                            </span>
                            <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Farklı Kategori') }}</span>
                        </div>
                    </div>
                    
                    <!-- Çeviri Tablosu -->
                    @if($list->translations->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-emerald-300">{{ __('Bu listede henüz hiç çeviri bulunmuyor.') }}</p>
                            <a href="{{ route('translate.index') }}" class="inline-block mt-4 text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200">
                                {{ __('Çeviri Aracına Dön ve Çeviri Ekle') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-emerald-600">
                                <thead class="bg-gray-50 dark:bg-emerald-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-emerald-300 uppercase tracking-wider">
                                            {{ __('Kaynak Metin') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-emerald-300 uppercase tracking-wider">
                                            {{ __('Çeviri') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-emerald-300 uppercase tracking-wider">
                                            {{ __('Diller') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-emerald-300 uppercase tracking-wider">
                                            {{ __('Kategori') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-emerald-800 divide-y divide-gray-200 dark:divide-emerald-700">
                                    @foreach($list->translations as $translation)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-emerald-700/70">
                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 dark:text-white">
                                                {{ $translation->source_text }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 dark:text-white">
                                                {{ $translation->target_text }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-emerald-300">
                                                {{ $translation->sourceLanguage->name }} → {{ $translation->targetLanguage->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-emerald-300">
                                                {{ $translation->category }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quiz Oyna Butonu -->
            @if(!$list->translations->isEmpty())
                <div class="mt-6 text-center">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-custom-green focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        {{ __('Bu Liste ile Quiz Oyna') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 