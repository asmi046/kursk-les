<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('items_summ', 12, 2)->default(0);
            $table->decimal('delivery_price', 12, 2)->default(0);
            $table->decimal('total_summ', 12, 2)->default(0);
            $table->string('payment_id')->nullable();
            $table->string('payment_status', 30)->default('pending');
            $table->string('payment_status_text')->nullable();
            $table->string('external_order_id')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps();

            $table->index('session_id');
            $table->index('payment_status');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_slug')->nullable();
            $table->string('product_name');
            $table->string('color')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('weight_grams', 10, 1)->default(0);
            $table->json('dimensions')->nullable();
            $table->timestamps();
        });

        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 50);
            $table->string('method', 30);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('tariff')->nullable();
            $table->json('delivery_date_range')->nullable();
            $table->string('city')->nullable();
            $table->string('pickup_point_id')->nullable();
            $table->string('pickup_point_address')->nullable();
            $table->string('street')->nullable();
            $table->string('house', 20)->nullable();
            $table->string('apartment', 20)->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamps();

            $table->index('provider');
            $table->index('pickup_point_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
