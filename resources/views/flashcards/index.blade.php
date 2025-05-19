<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight">
            {{ __('Kelime Kartları') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- İlerleme Özeti -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Genel İlerleme') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-gray-50 dark:bg-emerald-700/30 rounded-lg p-4 text-center">
                        <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $totalProgress }}</span>
                        <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Toplam Çalışılan Kelime') }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-emerald-700/30 rounded-lg p-4 text-center">
                        <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $knownCount }}</span>
                        <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Bilinen Kelime') }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-emerald-700/30 rounded-lg p-4 text-center">
                        <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $progressPercentage }}%</span>
                        <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Başarı Oranı') }}</span>
                    </div>
                </div>
                
                <!-- İlerleme Çubuğu -->
                <div class="w-full bg-gray-200 dark:bg-emerald-900 rounded-full h-2.5 mb-6">
                    <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('flashcards.stats') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-custom-green hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-green">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        {{ __('Detaylı İstatistikleri Görüntüle') }}
                    </a>
                </div>
            </div>
            
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
            
            @if (session('info'))
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Çalışma Listesi Seçimi -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Çalışmaya Başla') }}</h3>
                
                <p class="text-gray-600 dark:text-gray-300 mb-6">{{ __('Çalışmak istediğiniz listeyi seçin ve kelime kartları ile öğrenmeye başlayın.') }}</p>
                
                @if($lists->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h4 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('Henüz Hiç Kelime Listeniz Yok') }}</h4>
                        <p class="mt-2 text-gray-500 dark:text-gray-400 mb-4">{{ __('Çalışmaya başlamadan önce kelime listeleri oluşturmalısınız.') }}</p>
                        <a href="{{ route('translate.lists.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-custom-green hover:bg-opacity-90">
                            {{ __('Listelerime Git') }}
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lists as $list)
                            <div class="border border-gray-200 dark:border-emerald-700 rounded-lg overflow-hidden flex flex-col h-full">
                                <div class="p-5 bg-gray-50 dark:bg-emerald-700/20 flex-grow">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $list->name }}</h4>
                                    
                                    @if($list->description)
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($list->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        <span>{{ $list->translations_count ?? 0 }} kelime</span>
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-white dark:bg-emerald-800 border-t border-gray-200 dark:border-emerald-700">
                                    <div class="grid grid-cols-2 gap-3">
                                        <form action="{{ route('flashcards.start') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                                            <button type="submit" class="w-full flex justify-center items-center px-3 py-2 bg-custom-green text-white text-sm font-medium rounded-md hover:bg-opacity-90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ __('Başla') }}
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('flashcards.study-unknown') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                                            <button type="submit" class="w-full flex justify-center items-center px-3 py-2 border border-custom-green text-custom-green text-sm font-medium rounded-md hover:bg-custom-green hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ __('Bilinmeyenler') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Çalışma İpuçları -->
            <div class="mt-6 bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Kelime Kartları İle Çalışma İpuçları') }}</h3>
                
                <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-custom-green mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Düzenli tekrar yapmak hafızada kalıcılığı artırır. Her gün birkaç dakika çalışın.') }}</span>
                    </li>
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-custom-green mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Kelimeleri yanlızca ezberlemek yerine, örnek cümleler içinde kullanmaya çalışın.') }}</span>
                    </li>
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-custom-green mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Kendinizi dürüstçe değerlendirin. Sadece gerçekten bildiğiniz kelimeleri "biliyorum" olarak işaretleyin.') }}</span>
                    </li>
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-custom-green mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('İstatistiklerinizi takip ederek ilerlemenizdeki desenleri gözlemleyin ve öğrenme stratejinizi buna göre ayarlayın.') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout> 