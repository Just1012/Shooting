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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('main_title_ar')->nullable();
            $table->string('main_title_en')->nullable();
            $table->text('desc_1_ar')->nullable();
            $table->text('desc_1_en')->nullable();
            $table->text('desc_2_ar')->nullable();
            $table->text('desc_2_en')->nullable();
            $table->string('secondary_title_ar')->nullable();
            $table->string('secondary_title_en')->nullable();
            $table->string('sector_1_ar')->nullable();
            $table->string('sector_1_en')->nullable();
            $table->string('sector_2_ar')->nullable();
            $table->string('sector_2_en')->nullable();
            $table->string('sector_3_ar')->nullable();
            $table->string('sector_3_en')->nullable();
            $table->string('sector_4_ar')->nullable();
            $table->string('sector_4_en')->nullable();
            $table->string('sector_5_ar')->nullable();
            $table->string('sector_5_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
