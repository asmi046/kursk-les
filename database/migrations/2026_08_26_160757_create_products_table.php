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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->comment('Название товара');
            $table->text('description')->nullable()->comment('Описание товара');
            $table->string('img')->comment('Путь к изображению');
            $table->string('slug')->unique()->comment('URL-идентификатор');
            $table->decimal('price', 8, 2)->comment('Цена');
            $table->decimal('old_price', 8, 2)->nullable()->comment('Старая цена');
            $table->string('model')->nullable()->comment('Модель/артикул');
            $table->string('type')->nullable()->comment('Тип товара');
            $table->string('wigth')->nullable()->comment('Ширина');
            $table->string('height')->nullable()->comment('Высота');
            $table->string('length')->nullable()->comment('Длина');
            $table->string('weight')->nullable()->comment('Вес');
            $table->string('material')->nullable()->comment('Материал');
            $table->string('color')->nullable()->comment('Цвет');
            $table->boolean('handle_exist')->default(false)->comment('Наличие ручки');
            $table->boolean('rust_exist')->default(false)->comment('Наличие ржавчины');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
