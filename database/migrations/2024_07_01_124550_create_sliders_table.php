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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('entertainment_id')->constrained()->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL'); 
            $table->boolean('active')->default(true);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
