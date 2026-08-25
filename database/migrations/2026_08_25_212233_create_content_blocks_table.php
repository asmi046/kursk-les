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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('group', 50)->indexed()->comment('Группа блока');
            $table->string('key', 50)->unique()->comment('Уникальный ключ');
            $table->string('title')->nullable()->comment('Заголовок');
            $table->text('value')->nullable()->comment('Значение/текст');
            $table->string('icon', 150)->nullable()->comment('Sprite иконка');
            $table->string('img', 800)->nullable()->comment('Изображение');
            $table->unsignedTinyInteger('order')->default(0)->comment('Порядок');
            $table->json('data')->nullable()->comment('Доп. данные');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
