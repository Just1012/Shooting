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
        Schema::create('hiring_pages', function (Blueprint $table) {
            $table->id();
            $table->text('head_sentence_ar')->nullable();
            $table->text('head_sentence_en')->nullable();
            $table->string('welcome_title_ar')->nullable();
            $table->string('welcome_title_en')->nullable();
            $table->string('hiring_title_ar')->nullable();
            $table->string('hiring_title_en')->nullable();
            $table->text('hiring_desc_ar')->nullable();
            $table->text('hiring_desc_en')->nullable();
            $table->string('training_title_ar')->nullable();
            $table->string('training_title_en')->nullable();
            $table->text('training_desc_ar')->nullable();
            $table->text('training_desc_en')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_pages');
    }
};
