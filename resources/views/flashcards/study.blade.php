<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight mb-4 sm:mb-0 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                {{ $list->name }} {{ __('- Kelime Kartları') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('flashcards.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- İlerleme Göstergesi -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-emerald-800 rounded-lg shadow-md p-4 mb-6">
                <div class="flex items-center mb-4 sm:mb-0">
                    <span id="currentCardIndex" class="text-2xl font-bold text-custom-green">1</span>
                    <span class="text-gray-600 dark:text-gray-300 mx-2">/</span>
                    <span id="totalCards" class="text-lg text-gray-600 dark:text-gray-300">{{ $translations->count() }}</span>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ __('kelime') }}</span>
                </div>
                
                <!-- İlerleme Çubuğu -->
                <div class="w-full sm:w-2/3 flex items-center">
                    <div class="w-full bg-gray-200 dark:bg-emerald-700/30 rounded-full h-2.5">
                        <div id="progressBar" class="bg-custom-green h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            
            <div id="flashcardContainer" class="flex-grow perspective-1000">
                @foreach($translations as $index => $translation)
                    <div class="flashcard {{ $index > 0 ? 'hidden' : '' }}" data-index="{{ $index }}" data-id="{{ $translation->id }}" data-status="{{ $progressData[$translation->id] ?? 'unknown' }}">
                        <!-- Üst Butonlar -->
                        <div class="mb-2 flex justify-between items-center">
                            <div class="flex items-center text-sm">
                                <span class="px-2.5 py-0.5 bg-custom-green bg-opacity-10 text-custom-green dark:bg-emerald-700/50 dark:text-emerald-200 text-xs font-medium rounded-full">
                                    {{ $translation->sourceLanguage->name }} → {{ $translation->targetLanguage->name }}
                                </span>
                                
                                @if($translation->category)
                                    <span class="ml-2 px-2.5 py-0.5 bg-gray-100 dark:bg-emerald-700/30 text-gray-800 dark:text-gray-200 text-xs font-medium rounded-full">
                                        {{ $translation->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="status-indicator {{ $progressData[$translation->id] == 'known' ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full h-3 w-3"></div>
                        </div>
                        
                        <!-- Kart -->
                        <div class="flip-card h-[320px] w-full cursor-pointer">
                            <div class="flip-card-inner relative w-full h-full">
                                <!-- Ön Yüz -->
                                <div class="flip-card-front absolute w-full h-full bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6 flex flex-col items-center justify-center backface-hidden">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('Kaynak Dil:') }} {{ $translation->sourceLanguage->name }}</span>
                                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white text-center mb-2">{{ $translation->source_text }}</h3>
                                    <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">{{ __('Çevirisi nedir?') }}</p>
                                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">{{ __('(Kartı çevirmek için tıklayın)') }}</p>
                                </div>
                                
                                <!-- Arka Yüz -->
                                <div class="flip-card-back absolute w-full h-full bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6 flex flex-col items-center justify-center backface-hidden">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ __('Hedef Dil:') }} {{ $translation->targetLanguage->name }}</span>
                                    <h3 class="text-2xl md:text-3xl font-bold text-custom-green dark:text-emerald-300 text-center mb-2">{{ $translation->target_text }}</h3>
                                    
                                    @if($translation->example_sentence)
                                        <div class="mt-4 p-3 bg-gray-50 dark:bg-emerald-700/20 rounded-md w-full">
                                            <p class="text-sm text-gray-700 dark:text-gray-200 italic">{{ $translation->example_sentence }}</p>
                                        </div>
                                    @endif
                                    
                                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">{{ __('(Kartı çevirmek için tıklayın)') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alt Butonlar -->
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <button class="dont-know-btn w-full py-3 px-4 border border-red-500 text-red-500 rounded-md font-medium hover:bg-red-500 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ __('Bilmiyorum') }}
                                </div>
                            </button>
                            <button class="know-btn w-full py-3 px-4 border border-green-500 text-green-500 rounded-md font-medium hover:bg-green-500 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Biliyorum') }}
                                </div>
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <!-- Sonuç Ekranı -->
                <div id="resultScreen" class="hidden bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-custom-green mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Tebrikler!') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">{{ __('Bu listedeki tüm kelimeleri gözden geçirdiniz.') }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-md mx-auto">
                        <a href="{{ route('flashcards.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-custom-green hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-green">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            {{ __('Listelere Dön') }}
                        </a>
                        <form action="{{ route('flashcards.study-unknown') }}" method="POST">
                            @csrf
                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                            <button type="submit" class="inline-flex justify-center items-center w-full px-4 py-2 border border-custom-green text-custom-green font-medium rounded-md hover:bg-custom-green hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Bilinmeyenleri Çalış') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
        .perspective-1000 {
            perspective: 1000px;
        }
        
        .flip-card {
            transition: transform 0.4s;
        }
        
        .flip-card.is-flipped .flip-card-inner {
            transform: rotateY(180deg);
        }
        
        .flip-card-inner {
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }
        
        .flip-card-front, .flip-card-back {
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        
        .flip-card-back {
            transform: rotateY(180deg);
        }
        
        .backface-hidden {
            backface-visibility: hidden;
        }
    </style>
    @endpush
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashcards = document.querySelectorAll('.flashcard');
            const flipCards = document.querySelectorAll('.flip-card');
            const progressBar = document.getElementById('progressBar');
            const currentIndexEl = document.getElementById('currentCardIndex');
            const totalCardsEl = document.getElementById('totalCards');
            const resultScreen = document.getElementById('resultScreen');
            
            let currentIndex = 0;
            const totalCards = flashcards.length;
            
            // Flashcard'ları ilk yükleme
            updateProgressBar();
            
            // Kart çevirme
            flipCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.toggle('is-flipped');
                });
            });
            
            // "Biliyorum" butonu
            const knowBtns = document.querySelectorAll('.know-btn');
            knowBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const card = this.closest('.flashcard');
                    const translationId = card.dataset.id;
                    
                    updateStatus(translationId, 'known', card);
                    card.querySelector('.status-indicator').classList.remove('bg-gray-300', 'dark:bg-gray-600');
                    card.querySelector('.status-indicator').classList.add('bg-green-500');
                    
                    moveToNextCard();
                });
            });
            
            // "Bilmiyorum" butonu
            const dontKnowBtns = document.querySelectorAll('.dont-know-btn');
            dontKnowBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const card = this.closest('.flashcard');
                    const translationId = card.dataset.id;
                    
                    updateStatus(translationId, 'unknown', card);
                    card.querySelector('.status-indicator').classList.remove('bg-green-500');
                    card.querySelector('.status-indicator').classList.add('bg-gray-300', 'dark:bg-gray-600');
                    
                    moveToNextCard();
                });
            });
            
            // Bir sonraki karta geç
            function moveToNextCard() {
                // Mevcut kartı gizle
                flashcards[currentIndex].classList.add('hidden');
                
                // Kart çevirme durumunu resetle
                flashcards[currentIndex].querySelector('.flip-card').classList.remove('is-flipped');
                
                // Bir sonraki karta geç
                currentIndex++;
                
                // İlerleme çubuğunu güncelle
                updateProgressBar();
                
                // Tüm kartlar bittiğinde
                if (currentIndex >= totalCards) {
                    // Sonuç ekranını göster
                    resultScreen.classList.remove('hidden');
                } else {
                    // Bir sonraki kartı göster
                    flashcards[currentIndex].classList.remove('hidden');
                }
            }
            
            // İlerleme çubuğunu güncelle
            function updateProgressBar() {
                const progress = Math.floor((currentIndex / totalCards) * 100);
                progressBar.style.width = progress + '%';
                currentIndexEl.textContent = currentIndex + 1 > totalCards ? totalCards : currentIndex + 1;
            }
            
            // Durum güncelleme AJAX isteği
            function updateStatus(translationId, status, card) {
                fetch('{{ route("flashcards.update-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        translation_id: translationId,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        card.dataset.status = status;
                    } else {
                        console.error('Durum güncellenemedi:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 