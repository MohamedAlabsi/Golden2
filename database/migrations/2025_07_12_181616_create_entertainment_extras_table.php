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
        Schema::create('entertainment_extras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entertainment_id')
                ->constrained()
                ->onDelete('cascade');
            $table->json('videos')->nullable();
            $table->json('cast')->nullable();
            $table->json('reviews')->nullable();
            $table->json('images')->nullable();
            $table->string('collection')->nullable();
            $table->json('seasons')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entertainment_extras');
    }
};
