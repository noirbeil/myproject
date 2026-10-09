<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id',
        'name',
        'type',
        'description',
        'total_quantity',
        'price_per_hour',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_hour' => 'decimal:2',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
    
    // Типы оборудования
    public static function getTypes(): array
    {
        return [
            'light' => 'Освещение',
            'light_modifier' => 'Модификатор света',
            'camera' => 'Камера',
            'lens' => 'Объектив',
            'stand' => 'Стойка/штатив',
            'tripod' => 'Штатив',
            'audio' => 'Аудио оборудование',
            'accessory' => 'Аксессуар',
            'other' => 'Другое',
        ];
    }
    
    // Получить название типа
    public function getTypeNameAttribute(): string
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }
}