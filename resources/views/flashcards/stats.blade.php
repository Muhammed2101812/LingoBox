<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight mb-4 sm:mb-0 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                {{ __('Kelime Kartları İstatistikleri') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('flashcards.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    {{ __('Kelime Kartlarına Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Genel İstatistikler -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Genel İstatistikler') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 dark:bg-emerald-700/30 rounded-lg p-4 text-center">
                        <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $totalTranslations }}</span>
                        <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Toplam Kelime') }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-emerald-700/30 rounded-lg p-4 text-center">
                        <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $totalProgress }}</span>
                        <span class="text-gray-600 dark:text-emerald-200 text-sm">{{ __('Çalışılan Kelime') }}</span>
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
                
                <!-- İlerleme çubuğu -->
                <div class="w-full bg-gray-200 dark:bg-emerald-900 rounded-full h-2.5 mt-6">
                    <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>
            
            <!-- Son 7 Gün Grafiği -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Son 7 Gün Aktivitesi') }}</h3>
                
                <div class="h-64">
                    <canvas id="weeklyActivityChart"></canvas>
                </div>
            </div>
            
            <!-- Motivasyon Mesajı -->
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Öğrenme Yolculuğunuz') }}</h3>
                        
                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            @if($progressPercentage >= 75)
                                <p>{{ __('Harika ilerleme kaydediyorsunuz! Kelimelerin %75\'inden fazlasını öğrendiniz. Bu tempoda devam ederseniz dil öğreniminizde çok hızlı ilerleyeceksiniz.') }}</p>
                            @elseif($progressPercentage >= 50)
                                <p>{{ __('İyi gidiyorsunuz! Kelimelerin yarısından fazlasını öğrendiniz. Düzenli tekrar yapmaya devam edin.') }}</p>
                            @elseif($progressPercentage >= 25)
                                <p>{{ __('Güzel bir başlangıç yaptınız. Daha fazla pratik yaparak ilerlemenizi hızlandırabilirsiniz.') }}</p>
                            @else
                                <p>{{ __('Henüz başlangıç aşamasındasınız. Düzenli çalışmak dil öğrenmenin anahtarıdır. Her gün birkaç dakika ayırmak bile büyük fark yaratacaktır.') }}</p>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('flashcards.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-custom-green hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Çalışmaya Devam Et') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyActivityChart').getContext('2d');
            
            // Chart.js için renkler
            const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-custom-green') || '#059669';
            const labelColor = document.querySelector('html').classList.contains('dark') ? '#e2e8f0' : '#4b5563';
            const gridColor = document.querySelector('html').classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            
            // Chart veri hazırlama
            const chartData = @json($chartData);
            const labels = Object.keys(chartData);
            const data = Object.values(chartData);
            
            // Chart oluşturma
            const weeklyActivityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.map(date => {
                        const d = new Date(date);
                        return d.toLocaleDateString('tr-TR', { weekday: 'short', day: 'numeric' });
                    }),
                    datasets: [{
                        label: '{{ __("Çalışılan Kelime") }}',
                        data: data,
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: document.querySelector('html').classList.contains('dark') ? '#1e3a8a' : '#ffffff',
                            titleColor: labelColor,
                            bodyColor: labelColor,
                            borderColor: gridColor,
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: labelColor,
                                precision: 0
                            },
                            grid: {
                                color: gridColor
                            }
                        },
                        x: {
                            ticks: {
                                color: labelColor
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Tema değişikliğinde grafiği güncelle
            document.addEventListener('dark-mode', function() {
                const newLabelColor = document.querySelector('html').classList.contains('dark') ? '#e2e8f0' : '#4b5563';
                const newGridColor = document.querySelector('html').classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                
                weeklyActivityChart.options.plugins.tooltip.backgroundColor = document.querySelector('html').classList.contains('dark') ? '#1e3a8a' : '#ffffff';
                weeklyActivityChart.options.plugins.tooltip.titleColor = newLabelColor;
                weeklyActivityChart.options.plugins.tooltip.bodyColor = newLabelColor;
                
                weeklyActivityChart.options.scales.y.ticks.color = newLabelColor;
                weeklyActivityChart.options.scales.y.grid.color = newGridColor;
                weeklyActivityChart.options.scales.x.ticks.color = newLabelColor;
                
                weeklyActivityChart.update();
            });
        });
    </script>
    @endpush
</x-app-layout> 