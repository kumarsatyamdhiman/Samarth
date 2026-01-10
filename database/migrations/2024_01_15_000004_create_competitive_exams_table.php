<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competitive_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained('education_sectors')->onDelete('cascade');
            $table->foreignId('stream_id')->nullable()->constrained('education_streams')->onDelete('set null');
            $table->string('key')->unique(); // jee-main, neet-ug, clat, etc.
            $table->string('name_hindi');
            $table->string('name_english');
            $table->string('sector'); // engineering, medicine, law, etc.
            $table->string('applicable_for'); // degree, diploma, govt_job
            $table->string('eligibility_class'); // 10th, 12th, graduation
            $table->json('eligibility_hindi')->nullable();
            $table->json('eligibility_english')->nullable();
            $table->string('exam_pattern')->nullable(); // MCQ, descriptive, practical
            $table->string('frequency')->nullable(); // yearly, twice a year, etc.
            $table->json('subjects_hindi')->nullable();
            $table->json('subjects_english')->nullable();
            $table->text('preparation_tips_hindi')->nullable();
            $table->text('preparation_tips_english')->nullable();
            $table->string('official_website')->nullable();
            $table->string('registration_period')->nullable(); // months when applications open
            $table->string('exam_months')->nullable(); // months when exam is conducted
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitive_exams');
    }
};
