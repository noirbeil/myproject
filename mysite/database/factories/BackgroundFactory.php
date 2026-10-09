<?php

namespace Database\Factories;

use App\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

class BackgroundFactory extends Factory
{
    public function definition(): array
    {
        $types = ['paper', 'fabric', 'digital', 'cyclorama', 'wall'];
        
        return [
            'studio_id' => Studio::factory(),
            'name' => $this->faker->colorName() . ' Background',
            'type' => $this->faker->randomElement($types),
            'color' => $this->faker->hexColor(),
            'additional_price' => $this->faker->numberBetween(0, 500),
            'is_active' => true,
        ];
    }
}