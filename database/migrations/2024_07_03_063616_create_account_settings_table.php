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
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL'); 
            $table->boolean('show_movies_only')->default(true);
            $table->boolean('show_movies_all')->default(false);
            $table->boolean('show_my_movies_and_all')->default(false);
            $table->boolean('show_series_only')->default(true);
            $table->boolean('show_series_all')->default(false);
            $table->boolean('show_my_series_and_all')->default(false);
            $table->boolean('notification')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_settings', function (Blueprint $table) {
            //
        });
    }
};
