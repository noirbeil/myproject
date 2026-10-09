<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Заголовок -->
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ $studioId ? 'Редактирование студии' : 'Создание новой студии' }}
                    </h2>

                    <!-- Вкладки (только для редактирования) -->
                    @if($studioId)
                        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                            <nav class="flex flex-wrap space-x-4">
                                <button wire:click="setActiveTab('basic')"
                                        @class([
                                            'py-3 px-4 border-b-2 font-medium text-sm',
                                            'border-blue-500 text-blue-600 dark:text-blue-400' => $activeTab === 'basic',
                                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'basic',
                                        ])>
                                    Основная информация
                                </button>
                                <button wire:click="setActiveTab('backgrounds')"
                                        @class([
                                            'py-3 px-4 border-b-2 font-medium text-sm',
                                            'border-blue-500 text-blue-600 dark:text-blue-400' => $activeTab === 'backgrounds',
                                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'backgrounds',
                                        ])>
                                    Фоны
                                </button>
                                <button wire:click="setActiveTab('equipment')"
                                        @class([
                                            'py-3 px-4 border-b-2 font-medium text-sm',
                                            'border-blue-500 text-blue-600 dark:text-blue-400' => $activeTab === 'equipment',
                                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'equipment',
                                        ])>
                                    Оборудование
                                </button>
                                <button wire:click="setActiveTab('photos')"
                                        @class([
                                            'py-3 px-4 border-b-2 font-medium text-sm',
                                            'border-blue-500 text-blue-600 dark:text-blue-400' => $activeTab === 'photos',
                                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' => $activeTab !== 'photos',
                                        ])>
                                    Фотографии
                                </button>
                            </nav>
                        </div>
                    @endif

                    <!-- Контент вкладок -->
                                        @if($activeTab === 'basic' || !$studioId)
                        <!-- Форма основной информации -->
                        <form wire:submit="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Название -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Название студии *
                                    </label>
                                    <input type="text" 
                                           id="name"
                                           wire:model="name"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- URL (slug) -->
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        URL (автоматически) *
                                    </label>
                                    <input type="text" 
                                           id="slug"
                                           wire:model="slug"
                                           readonly
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-gray-50">
                                    @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Адрес -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Адрес *
                                    </label>
                                    <input type="text" 
                                           id="address"
                                           wire:model="address"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Описание -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Описание
                                    </label>
                                    <textarea id="description"
                                              wire:model="description"
                                              rows="4"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Цена за час -->
                                <div>
                                    <label for="price_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Цена за час (₽) *
                                    </label>
                                    <input type="number" 
                                           id="price_per_hour"
                                           wire:model="price_per_hour"
                                           min="0"
                                           step="100"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('price_per_hour') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Минимальное время бронирования -->
                                <div>
                                    <label for="min_booking_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Минимальное время бронирования (часы) *
                                    </label>
                                    <input type="number" 
                                           id="min_booking_hours"
                                           wire:model="min_booking_hours"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('min_booking_hours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Статус -->
                                <div>
                                    <label for="is_active" class="flex items-center space-x-2">
                                        <input type="checkbox" 
                                               id="is_active"
                                               wire:model="is_active"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Студия активна
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.studios.index') }}" 
                                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                                    ← Назад к списку
                                </a>
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    {{ $studioId ? 'Сохранить изменения' : 'Создать студию' }}
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Вкладка управления фонами -->
                    @if($activeTab === 'backgrounds' && $studioId)
                        <div>
                            @livewire('admin.studio.background-manager', ['studio' => $studio])
                        </div>
                        
                        <!-- Кнопка возврата -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.studios.index') }}" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                                ← Назад к списку
                            </a>
                        </div>
                    @endif

                    <!-- Вкладка управления оборудованием -->
                    @if($activeTab === 'equipment' && $studioId)
                        <div>
                            @livewire('admin.studio.equipment-manager', ['studio' => $studio])
                        </div>
                        
                        <!-- Кнопка возврата -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.studios.index') }}" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                                ← Назад к списку
                            </a>
                        </div>
                    @endif

                    <!-- Вкладка управления фотографиями -->
                    @if($activeTab === 'photos' && $studioId)
                        <div>
                            <!-- Загрузка фотографий -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Фотографии студии</h3>
                                
                                <!-- Существующие фото -->
                                @if(is_array($existingPhotos) && count($existingPhotos) > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Текущие фотографии:</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($existingPhotos as $index => $photo)
                                                <div class="relative">
                                                    @if($photo)
                                                        <img src="{{ Storage::url($photo) }}" 
                                                             alt="Фото студии" 
                                                             class="w-full h-40 object-cover rounded-lg">
                                                        <button type="button"
                                                                wire:click="removePhoto({{ $index }})"
                                                                wire:confirm="Удалить это фото?"
                                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                                            ×
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Загрузка новых фото -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Добавить новые фотографии:
                                    </label>
                                    <input type="file" 
                                           wire:model="photos"
                                           multiple
                                           accept="image/*"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Можно загрузить несколько фотографий (максимум 2MB каждая)
                                    </p>
                                    @error('photos.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Предпросмотр загружаемых фото -->
                                @if(is_array($photos) && count($photos) > 0)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Предпросмотр:</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($photos as $index => $photo)
                                                <div>
                                                    @if($photo && method_exists($photo, 'temporaryUrl'))
                                                        <img src="{{ $photo->temporaryUrl() }}" 
                                                             alt="Предпросмотр" 
                                                             class="w-full h-40 object-cover rounded-lg">
                                                        <p class="text-xs text-gray-500 text-center mt-1">{{ $photo->getClientOriginalName() }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Кнопка сохранения и возврата -->
                            <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.studios.index') }}" 
                                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                                    ← Назад к списку
                                </a>
                                <button wire:click="save"
                                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    Сохранить фотографии
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Сообщения -->
                    @if(session()->has('message'))
                        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900 dark:text-green-300">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>