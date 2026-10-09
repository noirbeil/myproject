<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderList extends Component
{
    public $perPage = 10;
    public $orderBy = 'order_number';
    public $orderDir = 'desc';
    public $search = '';

    public function render()
    {
        $message = 'просто текст';
        return view('livewire.order-list',[
            'message'=> $message,
            'number' => 42,
            'orders'=> Order::query()
                            ->where('order_number','like','%'.$this->search.'%')
                            ->orderBy($this->orderBy, $this->orderDir)
                            ->paginate($this->perPage),
        ]);
    }
}
