<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Background;
use App\Models\Studio;
use Livewire\Component;

class BackgroundManager extends Component
{
    public Studio $studio;
    public $backgrounds = [];
    public $showForm = false;
    public $editingBackgroundId = null;
    
    // Поля формы
    public $name = '';
    public $type = 'paper';
    public $color = '#ffffff';
    public $additional_price = 0;
    public $is_active = true;

    public function mount(Studio $studio)
    {
        $this->studio = $studio;
        $this->loadBackgrounds();
    }

    public function loadBackgrounds()
    {
        $this->backgrounds = $this->studio->backgrounds()->orderBy('name')->get()->toArray();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingBackgroundId = null;
    }

    public function showEditForm($backgroundId)
    {
        $background = Background::find($backgroundId);
        
        if ($background && $background->studio_id === $this->studio->id) {
            $this->editingBackgroundId = $background->id;
            $this->name = $background->name;
            $this->type = $background->type;
            $this->color = $background->color ?? '#ffffff';
            $this->additional_price = $background->additional_price;
            $this->is_active = $background->is_active;
            $this->showForm = true;
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'paper';
        $this->color = '#ffffff';
        $this->additional_price = 0;
        $this->is_active = true;
        $this->editingBackgroundId = null;
    }

    public function saveBackground()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:paper,fabric,digital,cyclorama,wall,other',
            'color' => 'nullable|string|max:7',
            'additional_price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'studio_id' => $this->studio->id,
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'additional_price' => $this->additional_price,
            'is_active' => $this->is_active,
        ];

        if ($this->editingBackgroundId) {
            $background = Background::find($this->editingBackgroundId);
            $background->update($data);
            $message = 'Фон успешно обновлен!';
        } else {
            Background::create($data);
            $message = 'Фон успешно создан!';
        }

        $this->loadBackgrounds();
        $this->showForm = false;
        $this->resetForm();
        
        $this->dispatch('background-saved');
        session()->flash('background-message', $message);
    }

    public function deleteBackground($backgroundId)
    {
        $background = Background::find($backgroundId);
        
        if ($background && $background->studio_id === $this->studio->id) {
            $background->delete();
            $this->loadBackgrounds();
            
            $this->dispatch('background-deleted');
            session()->flash('background-message', 'Фон успешно удален!');
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function render()
    {
        $types = Background::getTypes();
        
        return view('livewire.admin.studio.background-manager', [
            'types' => $types,
        ]);
    }
}