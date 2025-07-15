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
        Schema::create('entertainments', function (Blueprint $table) {
            $table->id();
            $table->integer('tmdb_id')->nullable();
            $table->integer('user_id')->unsigned()->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL'); 
            $table->boolean('adult')->nullable();
            $table->string('media_type')->nullable();  
            $table->boolean('check')->default(false);  
            $table->string('title')->nullable();
            $table->boolean('video')->nullable();
            $table->text('overview')->nullable();
            $table->json('genre_ids')->nullable();
            $table->float('popularity')->nullable();
            $table->integer('vote_count')->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->float('vote_average')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->string('original_title')->nullable();
            $table->string('original_language')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entertainments');
    }
};
