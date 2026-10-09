<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название студии
            $table->string('slug')->unique(); // ЧПУ для URL
            $table->text('description')->nullable(); // Описание
            $table->string('address'); // Адрес
            $table->decimal('price_per_hour', 10, 2); // Цена за час
            $table->integer('min_booking_hours')->default(1); // Минимальное время бронирования
            $table->json('photos')->nullable(); // Массив фото (пути к файлам)
            $table->boolean('is_active')->default(true); // Активна ли студия
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
