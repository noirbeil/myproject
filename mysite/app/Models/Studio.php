<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'price_per_hour',
        'min_booking_hours',
        'photos',
        'is_active'
    ];

    protected $casts = [
        'photos' => 'array',
        'is_active' => 'boolean',
        'price_per_hour' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($studio) {
            if (empty($studio->slug)) {
                $studio->slug = Str::slug($studio->name) . '-' . Str::random(6);
            }
        });
    }

    // Связи
    public function backgrounds()
    {
        return $this->hasMany(Background::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    // Активные фоны
    public function activeBackgrounds()
    {
        return $this->backgrounds()->where('is_active', true);
    }

    // Активное оборудование
    public function activeEquipment()
    {
        return $this->equipment()->where('is_active', true);
    }
}
