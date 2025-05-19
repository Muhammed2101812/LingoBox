<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-emerald-200 leading-tight mb-4 sm:mb-0">
                {{ __('Listelerim') }}
            </h2>
            <button id="createListBtn" class="px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-custom-green focus:ring-offset-2 transition ease-in-out duration-150 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('Yeni Liste Oluştur') }}
            </button>
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

            @if($lists->isEmpty())
                <x-card>
                    <div class="py-12 px-6 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('Henüz hiç listeniz yok') }}</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-300">{{ __('Kelimelerinizi organize etmek için listeler oluşturun.') }}</p>
                        <div class="mt-6">
                            <button id="emptyStateCreateListBtn" class="inline-flex items-center px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('İlk Listenizi Oluşturun') }}
                            </button>
                        </div>
                    </div>
                </x-card>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lists as $list)
                        <x-card class="h-full flex flex-col">
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-custom-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ $list->name }}
                                </h3>
                                
                                @if($list->description)
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ Str::limit($list->description, 100) }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <span>{{ $list->translations_count ?? 0 }} kelime</span>
                                </div>
                            </div>
                            
                            <div class="px-6 py-3 bg-gray-50 dark:bg-emerald-700/30 border-t border-gray-100 dark:border-emerald-600/20 flex justify-between items-center mt-auto">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $list->created_at->format('d.m.Y') }}
                                </p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('translate.lists.show', $list) }}" class="text-gray-500 dark:text-gray-300 hover:text-custom-green dark:hover:text-emerald-300 transition-colors duration-200" title="{{ __('Görüntüle') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="#" class="edit-list text-gray-500 dark:text-gray-300 hover:text-custom-green dark:hover:text-emerald-300 transition-colors duration-200" data-list-id="{{ $list->id }}" data-list-name="{{ $list->name }}" data-list-description="{{ $list->description }}" title="{{ __('Düzenle') }}">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L19.5 12.75l-4.243 4.243L10.5 16.5l4.243-4.243-2.828-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('translate.lists.destroy', $list) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Bu listeyi silmek istediğinizden emin misiniz?') }}');">
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

                @if($lists->hasPages())
                    <div class="mt-6">
                        {{ $lists->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Liste Oluşturma Modalı -->
    <div id="createListModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" id="modalOverlay"></div>
        <div class="bg-white dark:bg-emerald-800 rounded-lg shadow-xl max-w-md w-full mx-4 z-10 relative">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">
                        {{ __('Yeni Liste Oluştur') }}
                    </h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="listForm" action="{{ route('translate.lists.create') }}" method="POST">
                    @csrf
                    <input type="hidden" id="listIdInput" name="list_id">
                    <div class="mb-4">
                        <label for="listName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Liste Adı') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="listName" name="name" class="w-full rounded-md border-gray-300 dark:border-emerald-600 dark:bg-emerald-700/30 dark:text-white shadow-sm focus:border-custom-green focus:ring focus:ring-custom-green focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-6">
                        <label for="listDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Açıklama') }}
                        </label>
                        <textarea id="listDescription" name="description" rows="3" class="w-full rounded-md border-gray-300 dark:border-emerald-600 dark:bg-emerald-700/30 dark:text-white shadow-sm focus:border-custom-green focus:ring focus:ring-custom-green focus:ring-opacity-50"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="cancelButton" class="mr-3 px-4 py-2 border border-gray-300 dark:border-emerald-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-emerald-700/30 hover:bg-gray-50 dark:hover:bg-emerald-700/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-green">
                            {{ __('İptal') }}
                        </button>
                        <button type="submit" class="px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-custom-green focus:ring-offset-2" id="submitButton">
                            {{ __('Oluştur') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('createListModal');
            const modalTitle = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');
            const listForm = document.getElementById('listForm');
            const listIdInput = document.getElementById('listIdInput');
            const listNameInput = document.getElementById('listName');
            const listDescriptionInput = document.getElementById('listDescription');
            
            // Modal açma fonksiyonları
            document.getElementById('createListBtn').addEventListener('click', openCreateModal);
            if (document.getElementById('emptyStateCreateListBtn')) {
                document.getElementById('emptyStateCreateListBtn').addEventListener('click', openCreateModal);
            }
            
            // Modal kapatma
            document.getElementById('closeModal').addEventListener('click', closeModal);
            document.getElementById('cancelButton').addEventListener('click', closeModal);
            document.getElementById('modalOverlay').addEventListener('click', closeModal);
            
            // Liste düzenleme butonları
            document.querySelectorAll('.edit-list').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openEditModal(this.dataset.listId, this.dataset.listName, this.dataset.listDescription);
                });
            });
            
            function openCreateModal() {
                listForm.action = "{{ route('translate.lists.create') }}";
                modalTitle.textContent = "{{ __('Yeni Liste Oluştur') }}";
                submitButton.textContent = "{{ __('Oluştur') }}";
                listIdInput.value = '';
                listNameInput.value = '';
                listDescriptionInput.value = '';
                modal.classList.remove('hidden');
            }
            
            function openEditModal(id, name, description) {
                listForm.action = "{{ url('/translate/lists') }}/" + id;
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                listForm.appendChild(methodInput);
                
                modalTitle.textContent = "{{ __('Listeyi Düzenle') }}";
                submitButton.textContent = "{{ __('Güncelle') }}";
                listIdInput.value = id;
                listNameInput.value = name || '';
                listDescriptionInput.value = description || '';
                modal.classList.remove('hidden');
            }
            
            function closeModal() {
                modal.classList.add('hidden');
                const methodInput = listForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }
            }
        });
    </script>
    @endpush
</x-app-layout> 