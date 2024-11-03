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
            // Drop foreign key constraint if it exists
            $table->dropForeign(['category_id']);

            // Drop the existing category_id column
            $table->dropColumn('category_id');

            // Add a new category_id column as JSON to store an array of IDs
            $table->string('categories_id')->nullable()->after('status'); // Replace 'other_column_name' with the column after which you want to place 'category_id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Drop the new JSON category_id column
            $table->dropColumn('category_id');

            // Add back the original category_id as an integer foreign key
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
