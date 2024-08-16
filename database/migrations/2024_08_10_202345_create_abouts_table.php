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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('main_title_ar')->nullable();
            $table->string('main_title_en')->nullable();
            $table->text('desc_1_ar')->nullable();
            $table->text('desc_1_en')->nullable();
            $table->text('desc_2_ar')->nullable();
            $table->text('desc_2_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
