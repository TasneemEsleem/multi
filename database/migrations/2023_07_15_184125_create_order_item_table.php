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
        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedFloat('price');
            $table->unsignedInteger('quantity');

            $table->foreignId('item_id')->nullable();
            $table->foreign('item_id')->on('items')->references('id')->restrictOnDelete();

            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')->on('order')->references('id')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['item_id','order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
