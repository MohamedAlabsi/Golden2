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
        Schema::table('entertainments', function (Blueprint $table) {
            $table->boolean('is_top_movie')->default(false)->after('poster_path');
            $table->boolean('is_top_series')->default(false)->after('is_top_movie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
