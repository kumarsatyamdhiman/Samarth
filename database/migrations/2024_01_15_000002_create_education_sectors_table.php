<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education_sectors', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // engineering, medicine, commerce, etc.
            $table->string('name_hindi');
            $table->string('name_english');
            $table->text('description_hindi');
            $table->text('description_english');
            $table->text('why_important_hindi')->nullable();
            $table->text('why_important_english')->nullable();
            $table->json('eligibility_10th_hindi')->nullable();
            $table->json('eligibility_10th_english')->nullable();
            $table->json('eligibility_12th_hindi')->nullable();
            $table->json('eligibility_12th_english')->nullable();
            $table->json('career_prospects_hindi')->nullable();
            $table->json('career_prospects_english')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon class
            $table->string('color')->nullable(); // Hex color code
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education_sectors');
    }
};
