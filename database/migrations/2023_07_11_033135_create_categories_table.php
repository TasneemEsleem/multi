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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignId('parent_id')->nullable();
            $table->foreign('parent_id')->on('categories')->references('id')->cascadeOnDelete();


            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->restrictOnDelete();

            $table->foreignId('restaurant_id')->nullable();
            $table->foreign('restaurant_id')->on('restaurants')->references('id')->restrictOnDelete();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
