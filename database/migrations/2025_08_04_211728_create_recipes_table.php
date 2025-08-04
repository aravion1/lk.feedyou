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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('chpu')->index();
            $table->boolean('is_publish');
            $table->timestamps();
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->foreignId('recipe_id');
            $table->foreignId('product_id');
            $table->float('count');
        });

        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id');
            $table->string('title');
            $table->string('description');
            $table->float('minutes')->default(0.0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('steps');
    }
};
