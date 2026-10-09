<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id',
        'name',
        'type',
        'color',
        'additional_price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'additional_price' => 'decimal:2',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
    
    // Типы фонов
    public static function getTypes(): array
    {
        return [
            'paper' => 'Бумажный',
            'fabric' => 'Тканевый',
            'digital' => 'Цифровой',
            'cyclorama' => 'Циклорама',
            'wall' => 'Стеновой',
            'other' => 'Другой',
        ];
    }
    
    // Получить название типа
    public function getTypeNameAttribute(): string
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }
}