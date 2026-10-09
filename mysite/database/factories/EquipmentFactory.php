<?php

namespace Database\Factories;

use App\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        $equipmentTypes = [
            ['name' => 'Profoto Flash', 'type' => 'light'],
            ['name' => 'Softbox 120cm', 'type' => 'light_modifier'],
            ['name' => 'Canon EOS R5', 'type' => 'camera'],
            ['name' => 'Sony 24-70mm Lens', 'type' => 'lens'],
            ['name' => 'Light Stand', 'type' => 'stand'],
            ['name' => 'Reflector', 'type' => 'accessory'],
            ['name' => 'Microphone Rode', 'type' => 'audio'],
            ['name' => 'Tripod Manfrotto', 'type' => 'tripod'],
        ];
        
        $randomEquipment = $this->faker->randomElement($equipmentTypes);

        return [
            'studio_id' => Studio::factory(),
            'name' => $randomEquipment['name'],
            'type' => $randomEquipment['type'],
            'description' => $this->faker->sentence(),
            'total_quantity' => $this->faker->numberBetween(1, 5),
            'price_per_hour' => $this->faker->numberBetween(0, 300),
            'is_active' => true,
        ];
    }
}