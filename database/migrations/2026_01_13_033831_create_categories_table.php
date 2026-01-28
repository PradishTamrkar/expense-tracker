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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); //Primary key
            $table->string('name'); //categiry name
            $table->string('slug')->unique(); //URL-friendly name
            $table->enum('type', ['income','expense']); //income or expense category
            $table->string('icon')->nullable(); //icon
            $table->string('color',7)->default('#000000'); //Hex color
            $table->text('description')->nullable(); //Optional description
            $table->boolean('is_active')->default(true); //Active or inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
