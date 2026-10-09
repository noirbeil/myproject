<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Studio;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class StudioList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    public function mount()
    {
        // Проверяем, является ли пользователь администратором
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет прав для доступа к этой странице.');
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function deleteStudio($studioId)
    {
        $studio = Studio::findOrFail($studioId);
        $studio->delete();
        
        session()->flash('message', 'Студия успешно удалена.');
    }

    public function render()
    {
        $studios = Studio::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.studio.studio-list', [
            'studios' => $studios,
        ]);
    }
}