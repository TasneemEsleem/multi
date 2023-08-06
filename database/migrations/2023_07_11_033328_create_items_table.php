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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->string('description')->nullable();
            $table->string('image');

            $table->foreignId('restaurant_id');
            $table->foreign('restaurant_id')->on('restaurants')->references('id')->restrictOnDelete();

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
