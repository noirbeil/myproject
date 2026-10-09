<div>
    @role('admin')
    I am a writer!
    @else
        I am not a writer...
    @endrole

    <h1>Hello world</h1>
    <p> {{ $message }}</p>
    <p> {{ $message . $number }}</p>

    <p>{{ $perPage }}</p>
    <p>{{ $orderBy }}</p>

    <input type="text" name="search" id="" wire:model.live="search">

    <select name="orderBy" id="" wire:model.live="orderBy">
        <option value="order_nubmer">Номер заказа</option>
        <option value="user_id">По пользователю</option>
        <option value="created_at">По времени создания</option>
    </select>

    <select name="orderDir" id="" wire:model.live="orderDir">
        <option value="desc">По убыванию</option>
        <option value="asc">По возрастанию</option>
    </select>

    <input type="number" name="perPage" wire:model.live="perPage">



    @forelse ($orders as $order)
        <div class="p-4 backdrop-blur">
            <h2>Название: {{ $order->order_number }}</h2>
            <p> Описание:{{ $order->description }}</p>
            <p>Создатель: {{ $order->user_id }}</p>
            <p>Дата создания: {{ $order->created_at }}</p>
        </div>
    @empty
        <div>
            <h2>Ничего не найдено</h2>
        </div>
    @endforelse
</div>
