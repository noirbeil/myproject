<div>
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Управление фонами</h3>
        @if(!$showForm)
            <button wire:click="showCreateForm" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                + Добавить фон
            </button>
        @endif
    </div>

    <!-- Форма создания/редактирования -->
    @if($showForm)
        <div class="mb-8 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900">
            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                {{ $editingBackgroundId ? 'Редактирование фона' : 'Создание нового фона' }}
            </h4>
            
            <form wire:submit.prevent="saveBackground">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Название -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Название фона *
                        </label>
                        <input type="text" 
                               id="name"
                               wire:model="name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Тип -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Тип фона *
                        </label>
                        <select id="type"
                                wire:model="type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Цвет -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Цвет фона
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="color" 
                                   id="color"
                                   wire:model="color"
                                   class="w-12 h-12 cursor-pointer rounded border border-gray-300">
                            <input type="text" 
                                   wire:model="color"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        </div>
                        @error('color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Дополнительная цена -->
                    <div>
                        <label for="additional_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Дополнительная цена (₽) *
                        </label>
                        <input type="number" 
                               id="additional_price"
                               wire:model="additional_price"
                               min="0"
                               step="50"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        @error('additional_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Статус -->
                    <div>
                        <label for="is_active" class="flex items-center space-x-2">
                            <input type="checkbox" 
                                   id="is_active"
                                   wire:model="is_active"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Фон активен
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Кнопки формы -->
                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button"
                            wire:click="cancel"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        {{ $editingBackgroundId ? 'Сохранить изменения' : 'Создать фон' }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Список фонов -->
    @if(count($backgrounds) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Название
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Тип
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Цвет
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Доп. цена
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Статус
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($backgrounds as $background)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $background['name'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $types[$background['type']] ?? $background['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($background['color'])
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded border border-gray-300" 
                                             style="background-color: {{ $background['color'] }}"></div>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $background['color'] }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ number_format($background['additional_price'], 0, ',', ' ') }} ₽
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($background['is_active'])
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Активен
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        Неактивен
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="showEditForm({{ $background['id'] }})" 
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                    Редактировать
                                </button>
                                <button wire:click="deleteBackground({{ $background['id'] }})" 
                                        wire:confirm="Вы уверены, что хотите удалить этот фон?"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Удалить
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
            <p class="text-gray-500 dark:text-gray-400">Фоны не добавлены</p>
            @if(!$showForm)
                <button wire:click="showCreateForm" 
                        class="mt-2 px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    + Добавить первый фон
                </button>
            @endif
        </div>
    @endif

    <!-- Сообщения -->
    @if(session()->has('background-message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900 dark:text-green-300">
            {{ session('background-message') }}
        </div>
    @endif
</div>