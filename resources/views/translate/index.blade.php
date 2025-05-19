<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight">
            {{ __('Çeviri Aracı') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-emerald-200 mb-4">{{ __('Metni Çevir') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sol Kısım: Çeviri Formu -->
                        <div>
                            <form id="translate-form" class="space-y-4">
                                @csrf
                                
                                <div class="flex space-x-4">
                                    <!-- Kaynak Dil -->
                                    <div class="w-1/2">
                                        <x-input-label for="source_lang_id" :value="__('Kaynak Dil')" class="dark:text-emerald-200" />
                                        <select id="source_lang_id" name="source_lang_id" class="block mt-1 w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-emerald-700 dark:border-emerald-600 dark:text-white">
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}" {{ $language->code == 'tr' ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- Hedef Dil -->
                                    <div class="w-1/2">
                                        <x-input-label for="target_lang_id" :value="__('Hedef Dil')" class="dark:text-emerald-200" />
                                        <select id="target_lang_id" name="target_lang_id" class="block mt-1 w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-emerald-700 dark:border-emerald-600 dark:text-white">
                                            @foreach($languages as $language)
                                                <option value="{{ $language->id }}" {{ $language->code == 'en' ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Çevrilecek Metin -->
                                <div>
                                    <x-input-label for="text" :value="__('Çevrilecek Metin')" class="dark:text-emerald-200" />
                                    <textarea id="text" name="text" rows="4" class="block mt-1 w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-emerald-700 dark:border-emerald-600 dark:text-white" placeholder="Çevrilecek metni girin..."></textarea>
                                </div>
                                
                                <!-- Çeviri Butonu -->
                                <div class="flex justify-end">
                                    <x-primary-button type="submit" id="translate-button">
                                        {{ __('Çevir') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Sağ Kısım: Çeviri Sonucu ve Kaydetme -->
                        <div id="translation-result" class="hidden">
                            <div class="p-4 bg-emerald-50 dark:bg-emerald-700 rounded-lg">
                                <h4 class="font-medium text-emerald-800 dark:text-emerald-200 mb-2">{{ __('Çeviri Sonucu') }}</h4>
                                
                                <div class="mb-4">
                                    <x-input-label for="source_text" :value="__('Kaynak Metin')" class="dark:text-emerald-200" />
                                    <div id="source_text_display" class="mt-1 p-3 bg-white dark:bg-emerald-600 rounded border border-gray-200 dark:border-emerald-500 dark:text-white"></div>
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="target_text" :value="__('Çeviri')" class="dark:text-emerald-200" />
                                    <div id="target_text_display" class="mt-1 p-3 bg-white dark:bg-emerald-600 rounded border border-gray-200 dark:border-emerald-500 dark:text-white"></div>
                                </div>
                                
                                <!-- Çeviriyi Kaydet -->
                                <form id="save-translation-form" class="mt-4">
                                    @csrf
                                    <input type="hidden" id="source_text" name="source_text">
                                    <input type="hidden" id="target_text" name="target_text">
                                    <input type="hidden" id="save_source_lang_id" name="source_lang_id">
                                    <input type="hidden" id="save_target_lang_id" name="target_lang_id">
                                    
                                    <div class="mb-3">
                                        <x-input-label for="category" :value="__('Kategori')" class="dark:text-emerald-200" />
                                        <x-text-input id="category" name="category" type="text" class="block mt-1 w-full" placeholder="Örn: Genel, Fiiller, Günlük Konuşma..." />
                                    </div>
                                    
                                    <div class="mb-3">
                                        <x-input-label for="list_id" :value="__('Kelime Listesi')" class="dark:text-emerald-200" />
                                        <select id="list_id" name="list_id" class="block mt-1 w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-emerald-700 dark:border-emerald-600 dark:text-white">
                                            <option value="">{{ __('Liste Seçin veya Yeni Oluşturun') }}</option>
                                            @foreach($lists as $list)
                                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div id="new-list-form" class="mb-3 hidden">
                                        <div class="p-3 bg-emerald-50 dark:bg-emerald-600 rounded border border-emerald-200 dark:border-emerald-500">
                                            <x-input-label for="list_name" :value="__('Yeni Liste Adı')" class="dark:text-emerald-200" />
                                            <x-text-input id="list_name" type="text" class="block mt-1 w-full" placeholder="Yeni liste adı..." />
                                            
                                            <x-input-label for="list_description" :value="__('Açıklama (Opsiyonel)')" class="mt-3 dark:text-emerald-200" />
                                            <textarea id="list_description" rows="2" class="block mt-1 w-full rounded-md border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-emerald-700 dark:border-emerald-600 dark:text-white" placeholder="Liste açıklaması..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-3">
                                        <x-primary-button type="button" id="new-list-button">
                                            {{ __('Yeni Liste') }}
                                        </x-primary-button>
                                        
                                        <x-primary-button type="submit" id="save-button">
                                            {{ __('Çeviriyi Kaydet') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kayıtlı Listeler -->
            <div class="mt-6 bg-white dark:bg-emerald-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-emerald-200 mb-4">{{ __('Kelime Listelerim') }}</h3>
                    
                    @if($lists->isEmpty())
                        <p class="text-gray-500 dark:text-emerald-300">{{ __('Henüz hiç kelime listeniz bulunmuyor. Yukarıdaki çeviri aracını kullanarak yeni listeler oluşturabilirsiniz.') }}</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($lists as $list)
                                <div class="p-4 bg-emerald-50 dark:bg-emerald-700 rounded-lg border border-emerald-100 dark:border-emerald-600">
                                    <h4 class="font-medium text-emerald-800 dark:text-emerald-200">{{ $list->name }}</h4>
                                    
                                    @if($list->description)
                                        <p class="text-sm text-gray-600 dark:text-emerald-300 mt-1">{{ $list->description }}</p>
                                    @endif
                                    
                                    <div class="mt-3 flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-emerald-400">
                                            {{ $list->translations_count ?? 0 }} kelime
                                        </span>
                                        
                                        <a href="{{ route('translate.lists.show', $list) }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-300 dark:hover:text-emerald-200">
                                            {{ __('Görüntüle') }} →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elemanlarını seçelim
            const translateForm = document.getElementById('translate-form');
            const saveTranslationForm = document.getElementById('save-translation-form');
            const translationResult = document.getElementById('translation-result');
            const newListButton = document.getElementById('new-list-button');
            const newListForm = document.getElementById('new-list-form');
            const listSelect = document.getElementById('list_id');
            
            // Çeviri işlemi
            translateForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(translateForm);
                const text = formData.get('text');
                
                if (!text || text.trim() === '') {
                    alert('Lütfen çevrilecek bir metin girin.');
                    return;
                }
                
                try {
                    // Çeviri butonunu devre dışı bırak ve yükleniyor göster
                    document.getElementById('translate-button').disabled = true;
                    document.getElementById('translate-button').textContent = 'Çevriliyor...';
                    
                    const response = await fetch('{{ route('translate.process') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error('Çeviri işlemi sırasında bir hata oluştu.');
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Çeviri sonucunu göster
                        document.getElementById('source_text_display').textContent = data.original;
                        document.getElementById('target_text_display').textContent = data.translation;
                        
                        // Kaydetme formu için değerleri ayarla
                        document.getElementById('source_text').value = data.original;
                        document.getElementById('target_text').value = data.translation;
                        document.getElementById('save_source_lang_id').value = formData.get('source_lang_id');
                        document.getElementById('save_target_lang_id').value = formData.get('target_lang_id');
                        
                        // Sonuç alanını göster
                        translationResult.classList.remove('hidden');
                    } else {
                        alert(data.message || 'Çeviri yapılırken bir hata oluştu.');
                    }
                } catch (error) {
                    alert(error.message);
                } finally {
                    // Çeviri butonunu tekrar aktif et
                    document.getElementById('translate-button').disabled = false;
                    document.getElementById('translate-button').textContent = 'Çevir';
                }
            });
            
            // Yeni Liste butonuna tıklanınca form göster/gizle
            newListButton.addEventListener('click', function() {
                newListForm.classList.toggle('hidden');
                listSelect.value = '';  // Liste seçimini sıfırla
            });
            
            // Liste seçilince yeni liste formunu gizle
            listSelect.addEventListener('change', function() {
                if (listSelect.value !== '') {
                    newListForm.classList.add('hidden');
                }
            });
            
            // Çeviriyi kaydetme işlemi
            saveTranslationForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Yeni liste oluşturulacak mı kontrol et
                const shouldCreateNewList = !newListForm.classList.contains('hidden');
                let listId = listSelect.value;
                
                if (shouldCreateNewList) {
                    const listName = document.getElementById('list_name').value;
                    
                    if (!listName || listName.trim() === '') {
                        alert('Lütfen liste adı girin.');
                        return;
                    }
                    
                    try {
                        // Yeni liste oluştur
                        const createListResponse = await fetch('{{ route('translate.lists.create') }}', {
                            method: 'POST',
                            body: JSON.stringify({
                                name: listName,
                                description: document.getElementById('list_description').value
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        });
                        
                        if (!createListResponse.ok) {
                            throw new Error('Liste oluşturulurken bir hata oluştu.');
                        }
                        
                        const listData = await createListResponse.json();
                        
                        if (listData.success) {
                            listId = listData.list.id;
                            
                            // Listeyi dropdown'a ekle
                            const option = document.createElement('option');
                            option.value = listId;
                            option.textContent = listName;
                            listSelect.appendChild(option);
                            listSelect.value = listId;
                            
                            // Yeni liste formunu gizle
                            newListForm.classList.add('hidden');
                        } else {
                            throw new Error(listData.message || 'Liste oluşturulurken bir hata oluştu.');
                        }
                    } catch (error) {
                        alert(error.message);
                        return;
                    }
                }
                
                // Çeviriyi kaydet
                try {
                    document.getElementById('save-button').disabled = true;
                    document.getElementById('save-button').textContent = 'Kaydediliyor...';
                    
                    const formData = new FormData(saveTranslationForm);
                    if (listId) {
                        formData.set('list_id', listId);
                    }
                    
                    const response = await fetch('{{ route('translate.save') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error('Çeviri kaydedilirken bir hata oluştu.');
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        alert('Çeviri başarıyla kaydedildi.');
                        
                        // Formu sıfırla
                        translateForm.reset();
                        saveTranslationForm.reset();
                        translationResult.classList.add('hidden');
                        
                        // Sayfayı yenile (opsiyonel)
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Çeviri kaydedilirken bir hata oluştu.');
                    }
                } catch (error) {
                    alert(error.message);
                } finally {
                    document.getElementById('save-button').disabled = false;
                    document.getElementById('save-button').textContent = 'Çeviriyi Kaydet';
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 