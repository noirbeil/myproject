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
        Schema::create('backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Название фона
            $table->string('type')->default('paper'); // Тип: paper, fabric, digital, etc
            $table->string('color')->nullable(); // Цвет фона
            $table->decimal('additional_price', 10, 2)->default(0); // Доплата за фон
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backgrounds');
    }
};
