<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education_streams', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // science, commerce, arts, vocational
            $table->string('name_hindi');
            $table->string('name_english');
            $table->text('description_hindi');
            $table->text('description_english');
            $table->json('subjects_hindi')->nullable();
            $table->json('subjects_english')->nullable();
            $table->json('career_paths_hindi')->nullable();
            $table->json('career_paths_english')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon class
            $table->string('color')->nullable(); // Hex color code
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education_streams');
    }
};
