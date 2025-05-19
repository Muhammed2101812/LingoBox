<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- İstatistik Kartı 1 -->
                <x-card class="p-6">
                    <div class="flex items-start">
                        <div class="bg-custom-green bg-opacity-10 p-3 rounded-full">
                            <svg class="h-8 w-8 text-custom-green" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-semibold text-gray-800">Toplam Kelime</h3>
                            <p class="mt-1 text-3xl font-bold text-custom-green">0</p>
                            <p class="mt-1 text-sm text-gray-500">Çeviri koleksiyonunuzdaki toplam kelime sayısı</p>
                        </div>
                    </div>
                </x-card>

                <!-- İstatistik Kartı 2 -->
                <x-card class="p-6">
                    <div class="flex items-start">
                        <div class="bg-blue-50 p-3 rounded-full">
                            <svg class="h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-semibold text-gray-800">Kategoriler</h3>
                            <p class="mt-1 text-3xl font-bold text-blue-500">0</p>
                            <p class="mt-1 text-sm text-gray-500">Oluşturduğunuz toplam kategori sayısı</p>
                        </div>
                    </div>
                </x-card>

                <!-- İstatistik Kartı 3 -->
                <x-card class="p-6">
                    <div class="flex items-start">
                        <div class="bg-purple-50 p-3 rounded-full">
                            <svg class="h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-semibold text-gray-800">Quiz Puanı</h3>
                            <p class="mt-1 text-3xl font-bold text-purple-500">0</p>
                            <p class="mt-1 text-sm text-gray-500">Tamamladığınız son quizin puanı</p>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Son Eklenen Kelimeler -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Son Eklenen Kelimeler</h2>
                <x-card>
                    <div class="px-6 py-4 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2">Henüz kelime eklemediniz</p>
                        <a href="{{ route('translations.create') }}" class="mt-4 inline-block text-custom-green hover:text-custom-green hover:underline">
                            İlk kelimenizi ekleyin
                        </a>
                    </div>
                </x-card>
            </div>
            
            <!-- Başlangıç İpuçları -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Başlangıç İpuçları</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-card class="p-6">
                        <h3 class="font-medium text-gray-800 mb-2 flex items-center">
                            <svg class="h-5 w-5 text-custom-green mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Kelime Ekleyin
                        </h3>
                        <p class="text-gray-600 text-sm">Öğrenmek istediğiniz yeni kelimeler ekleyin. Bu kelimeleri daha sonra quiz ve flashcardlarla tekrar edebilirsiniz.</p>
                    </x-card>
                    <x-card class="p-6">
                        <h3 class="font-medium text-gray-800 mb-2 flex items-center">
                            <svg class="h-5 w-5 text-custom-green mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Düzenli Tekrar Edin
                        </h3>
                        <p class="text-gray-600 text-sm">Kelimeleri quizler ve flashcardlar ile düzenli olarak tekrar edin. Bu, kelimeleri uzun süreli hafızanıza almanıza yardımcı olur.</p>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
