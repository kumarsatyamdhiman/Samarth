<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained('education_sectors')->onDelete('cascade');
            $table->foreignId('stream_id')->nullable()->constrained('education_streams')->onDelete('set null');
            $table->string('key')->unique(); // engineering-degree, medical-mbbs, etc.
            $table->string('name_hindi');
            $table->string('name_english');
            $table->text('description_hindi');
            $table->text('description_english');
            $table->string('duration'); // e.g., "4 years", "2 years", "6 months"
            $table->text('eligibility_hindi');
            $table->text('eligibility_english');
            $table->text('job_prospects_hindi')->nullable();
            $table->text('job_prospects_english')->nullable();
            $table->text('avg_salary_hindi')->nullable();
            $table->text('avg_salary_english')->nullable();
            $table->json('required_subjects_hindi')->nullable();
            $table->json('required_subjects_english')->nullable();
            $table->json('skills_needed_hindi')->nullable();
            $table->json('skills_needed_english')->nullable();
            $table->string('course_type')->nullable(); // degree, diploma, certificate, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
