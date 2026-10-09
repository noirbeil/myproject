<?php


namespace App\Livewire\Admin\Studio;

use App\Models\Studio;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudioForm extends Component
{
    use WithFileUploads;

    public $studio;
    public $studioId;
    public $name;
    public $slug;
    public $description;
    public $address;
    public $price_per_hour;
    public $min_booking_hours = 1;
    public $is_active = true;
    
    // Для загрузки фото
    public $photos = [];
    public $uploadedPhotos = [];
    public $existingPhotos = [];

    // Активная вкладка
    public $activeTab = 'basic';

    public function mount($studio = null)
    {
        // Проверяем права доступа
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет прав для доступа к этой странице.');
        }

        if ($studio) {
            $this->studio = Studio::findOrFail($studio);
            $this->studioId = $this->studio->id;
            $this->name = $this->studio->name;
            $this->slug = $this->studio->slug;
            $this->description = $this->studio->description;
            $this->address = $this->studio->address;
            $this->price_per_hour = $this->studio->price_per_hour;
            $this->min_booking_hours = $this->studio->min_booking_hours;
            $this->is_active = $this->studio->is_active;
            
            // Исправляем: убеждаемся, что это массив
            $photos = $this->studio->photos ?? [];
            if (is_string($photos) && !empty($photos)) {
                // Если это JSON строка, декодируем
                $decoded = json_decode($photos, true);
                $this->existingPhotos = is_array($decoded) ? $decoded : [$photos];
            } elseif (is_array($photos)) {
                $this->existingPhotos = $photos;
            } else {
                $this->existingPhotos = [];
            }
        } else {
            $this->existingPhotos = [];
        }
    }

    public function updatedName($value)
    {
        if (!$this->studioId) {
            $this->slug = \Illuminate\Support\Str::slug($value) . '-' . \Illuminate\Support\Str::random(6);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:studios,slug,' . $this->studioId,
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'price_per_hour' => 'required|numeric|min:0',
            'min_booking_hours' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'photos.*' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Обработка загруженных фото
        $allPhotos = $this->existingPhotos;
        
        foreach ($this->photos as $photo) {
            $path = $photo->store('studios/photos', 'public');
            $allPhotos[] = $path;
        }

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'address' => $this->address,
            'price_per_hour' => $this->price_per_hour,
            'min_booking_hours' => $this->min_booking_hours,
            'is_active' => $this->is_active,
            'photos' => $allPhotos,
        ];

        if ($this->studioId) {
            $this->studio->update($data);
            $message = 'Студия успешно обновлена!';
        } else {
            Studio::create($data);
            $message = 'Студия успешно создана!';
        }

        session()->flash('message', $message);
        return redirect()->route('admin.studios.index');
    }

    public function removePhoto($index)
    {
        if (isset($this->existingPhotos[$index])) {
            $photoPath = $this->existingPhotos[$index];
            
            // Проверяем, существует ли файл
            if (Storage::disk('public')->exists($photoPath)) {
                // Удаляем файл из хранилища
                Storage::disk('public')->delete($photoPath);
            }
            
            // Удаляем из массива
            unset($this->existingPhotos[$index]);
            $this->existingPhotos = array_values($this->existingPhotos);
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.admin.studio.studio-form', [
            'studio' => $this->studioId ? Studio::find($this->studioId) : null,
        ]);
    }
}