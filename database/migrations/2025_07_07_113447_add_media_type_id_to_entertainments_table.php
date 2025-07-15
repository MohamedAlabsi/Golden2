<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {
            $table->unsignedTinyInteger('media_type_id')
                ->default(1)
                ->after('media_type');

            $table->foreign('media_type_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');
        });

         DB::table('entertainments')
            ->where('media_type', 'tv')
            ->update(['media_type_id' => 2]);

        DB::table('entertainments')
            ->where('media_type', '!=', 'tv')
            ->update(['media_type_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {
            //
        });
    }
};
