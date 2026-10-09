<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем 3 студии
        Studio::factory(3)
            ->hasBackgrounds(5) // У каждой студии 5 фонов
            ->hasEquipment(8)   // У каждой студии 8 единиц оборудования
            ->create();
        

    }
}