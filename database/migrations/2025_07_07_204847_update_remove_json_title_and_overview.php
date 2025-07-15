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
                $table->renameColumn('title', 'title1');
                $table->renameColumn('overview', 'overview1');


                $table->renameColumn('title_json', 'title');
                $table->renameColumn('overview_json', 'overview');

        });
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
