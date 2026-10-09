<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Equipment;
use App\Models\Studio;
use Livewire\Component;

class EquipmentManager extends Component
{
    public Studio $studio;
    public $equipment = [];
    public $showForm = false;
    public $editingEquipmentId = null;
    
    // Поля формы
    public $name = '';
    public $type = 'light';
    public $description = '';
    public $total_quantity = 1;
    public $price_per_hour = 0;
    public $is_active = true;

    public function mount(Studio $studio)
    {
        $this->studio = $studio;
        $this->loadEquipment();
    }

    public function loadEquipment()
    {
        $this->equipment = $this->studio->equipment()->orderBy('name')->get()->toArray();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingEquipmentId = null;
    }

    public function showEditForm($equipmentId)
    {
        $equipment = Equipment::find($equipmentId);
        
        if ($equipment && $equipment->studio_id === $this->studio->id) {
            $this->editingEquipmentId = $equipment->id;
            $this->name = $equipment->name;
            $this->type = $equipment->type;
            $this->description = $equipment->description ?? '';
            $this->total_quantity = $equipment->total_quantity;
            $this->price_per_hour = $equipment->price_per_hour;
            $this->is_active = $equipment->is_active;
            $this->showForm = true;
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'light';
        $this->description = '';
        $this->total_quantity = 1;
        $this->price_per_hour = 0;
        $this->is_active = true;
        $this->editingEquipmentId = null;
    }

    public function saveEquipment()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:light,light_modifier,camera,lens,stand,tripod,audio,accessory,other',
            'description' => 'nullable|string',
            'total_quantity' => 'required|integer|min:1',
            'price_per_hour' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'studio_id' => $this->studio->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'total_quantity' => $this->total_quantity,
            'price_per_hour' => $this->price_per_hour,
            'is_active' => $this->is_active,
        ];

        if ($this->editingEquipmentId) {
            $equipment = Equipment::find($this->editingEquipmentId);
            $equipment->update($data);
            $message = 'Оборудование успешно обновлено!';
        } else {
            Equipment::create($data);
            $message = 'Оборудование успешно создано!';
        }

        $this->loadEquipment();
        $this->showForm = false;
        $this->resetForm();
        
        $this->dispatch('equipment-saved');
        session()->flash('equipment-message', $message);
    }

    public function deleteEquipment($equipmentId)
    {
        $equipment = Equipment::find($equipmentId);
        
        if ($equipment && $equipment->studio_id === $this->studio->id) {
            $equipment->delete();
            $this->loadEquipment();
            
            $this->dispatch('equipment-deleted');
            session()->flash('equipment-message', 'Оборудование успешно удалено!');
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function render()
    {
        $types = Equipment::getTypes();
        
        return view('livewire.admin.studio.equipment-manager', [
            'types' => $types,
        ]);
    }
}