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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->text('header_section_ar')->nullable();
            $table->text('header_section_en')->nullable();
            $table->string('goals_title_ar')->nullable();
            $table->string('goals_title_en')->nullable();
            $table->longText('goals_desc_ar')->nullable();
            $table->longText('goals_desc_en')->nullable();
            $table->string('vision_title_ar')->nullable();
            $table->string('vision_title_en')->nullable();
            $table->longText('vision_desc_ar')->nullable();
            $table->longText('vision_desc_en')->nullable();
            $table->string('journey_title_ar')->nullable();
            $table->string('journey_title_en')->nullable();
            $table->longText('journey_desc_ar')->nullable();
            $table->longText('journey_desc_en')->nullable();
            $table->string('team_title_ar')->nullable();
            $table->string('team_title_en')->nullable();
            $table->longText('team_desc_ar')->nullable();
            $table->longText('team_desc_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
