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
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('thumbnail_title')->nullable();
            $table->text('thumbnail_alt')->nullable();
            $table->string('main_image_title')->nullable();
            $table->text('main_image_alt')->nullable();
            $table->string('meta_image_title')->nullable();
            $table->text('meta_image_alt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('thumbnail_title');
            $table->dropColumn('thumbnail_alt');
            $table->dropColumn('main_image_title');
            $table->dropColumn('main_image_alt');
            $table->dropColumn('meta_image_title');
            $table->dropColumn('meta_image_alt');
        });
    }
};
