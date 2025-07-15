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
        Schema::create('movie_cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_cart_id')->constrained('movie_carts')->onDelete('cascade');
            $table->unsignedBigInteger('movie_id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_cart_items');
    }
};
