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
        Schema::table('our_work_details', function (Blueprint $table) {
            $table->string('title_color');
            $table->string('title_back_color');
            $table->string('details_color');
            $table->string('details_back_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('our_work_details', function (Blueprint $table) {
            $table->dropColumn('title_color');
            $table->dropColumn('title_back_color');
            $table->dropColumn('details_color');
            $table->dropColumn('details_back_color');
        });
    }
};
