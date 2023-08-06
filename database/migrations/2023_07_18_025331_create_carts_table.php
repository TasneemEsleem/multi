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
        Schema::create('carts', function (Blueprint $table) {
            // uniqe unifersal uniqe identifer
            $table->uuid('id')->primary();

            $table->uuid('cookie_id');

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();

            $table->foreignId('item_id')->nullable();
            $table->foreign('item_id')->on('items')->references('id')->cascadeOnDelete();
            $table->unsignedInteger('quantity');

            $table->timestamps();
            $table->unique(['cookie_id','item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
