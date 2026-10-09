<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Заголовок и кнопка создания -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Управление студиями</h2>
                        <a href="{{ route('admin.studios.create') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            + Добавить студию
                        </a>
                    </div>

                    <!-- Поиск и фильтры -->
                    <div class="mb-6">
                        <div class="flex gap-4 items-center">
                            <div class="flex-1">
                                <input type="text" 
                                       wire:model.live="search" 
                                       placeholder="Поиск по названию, адресу или описанию..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <select wire:model.live="perPage" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Таблица студий -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortBy('name')">
                                        Название
                                        @if($sortField === 'name')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Адрес
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortBy('price_per_hour')">
                                        Цена/час
                                        @if($sortField === 'price_per_hour')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Фоны
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Оборудование
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
                                @forelse($studios as $studio)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $studio->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300 truncate max-w-xs">
                                                {{ $studio->address }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900 dark:text-white font-semibold">
                                                {{ number_format($studio->price_per_hour, 0, ',', ' ') }} ₽
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                {{ $studio->backgrounds->count() }}
                                            </span>
                                        </td>
   <td class="px-6 py-4 whitespace-nowrap">
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
        {{ $studio->equipment->count() }}
    </span>
</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($studio->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Активна
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Неактивна
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.studios.edit', $studio) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                                Редактировать
                                            </a>
                                            <button wire:click="deleteStudio({{ $studio->id }})" 
                                                    wire:confirm="Вы уверены, что хотите удалить эту студию?"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Студии не найдены
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-4">
                        {{ $studios->links() }}
                    </div>

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