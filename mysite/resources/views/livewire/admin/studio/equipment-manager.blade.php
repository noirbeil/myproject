<div>
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Управление оборудованием</h3>
        @if(!$showForm)
            <button wire:click="showCreateForm" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                + Добавить оборудование
            </button>
        @endif
    </div>

    <!-- Форма создания/редактирования -->
    @if($showForm)
        <div class="mb-8 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900">
            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                {{ $editingEquipmentId ? 'Редактирование оборудования' : 'Создание нового оборудования' }}
            </h4>
            
            <form wire:submit.prevent="saveEquipment">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Название -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Название оборудования *
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
                            Тип оборудования *
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

                    <!-- Общее количество -->
                    <div>
                        <label for="total_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Общее количество *
                        </label>
                        <input type="number" 
                               id="total_quantity"
                               wire:model="total_quantity"
                               min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        @error('total_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Цена в час -->
                    <div>
                        <label for="price_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Цена аренды в час (₽) *
                        </label>
                        <input type="number" 
                               id="price_per_hour"
                               wire:model="price_per_hour"
                               min="0"
                               step="10"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        @error('price_per_hour') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Описание -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Описание
                        </label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Статус -->
                    <div>
                        <label for="is_active" class="flex items-center space-x-2">
                            <input type="checkbox" 
                                   id="is_active"
                                   wire:model="is_active"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Оборудование активно
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
                        {{ $editingEquipmentId ? 'Сохранить изменения' : 'Создать оборудование' }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Список оборудования -->
    @if(count($equipment) > 0)
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
                            Количество
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Цена/час
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
                    @foreach($equipment as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item['name'] }}
                                    </div>
                                    @if($item['description'])
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Illuminate\Support\Str::limit($item['description'], 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $types[$item['type']] ?? $item['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item['total_quantity'] }} шт.
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ number_format($item['price_per_hour'], 0, ',', ' ') }} ₽
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item['is_active'])
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Активно
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        Неактивно
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="showEditForm({{ $item['id'] }})" 
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                    Редактировать
                                </button>
                                <button wire:click="deleteEquipment({{ $item['id'] }})" 
                                        wire:confirm="Вы уверены, что хотите удалить это оборудование?"
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
            <p class="text-gray-500 dark:text-gray-400">Оборудование не добавлено</p>
            @if(!$showForm)
                <button wire:click="showCreateForm" 
                        class="mt-2 px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    + Добавить первое оборудование
                </button>
            @endif
        </div>
    @endif

    <!-- Сообщения -->
    @if(session()->has('equipment-message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900 dark:text-green-300">
            {{ session('equipment-message') }}
        </div>
    @endif
</div>