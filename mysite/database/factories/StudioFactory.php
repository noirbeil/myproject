<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Studio>
 */
class StudioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Photo Studio',
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraphs(3, true),
            'address' => $this->faker->address(),
            'price_per_hour' => $this->faker->numberBetween(1000, 5000),
            'min_booking_hours' => $this->faker->numberBetween(1, 3),
            'photos' => json_encode([ // Изменено: теперь JSON
                'studios/photos/default1.jpg',
                'studios/photos/default2.jpg',
                'studios/photos/default3.jpg',
            ]),
            'is_active' => true,
        ];
    }
}
