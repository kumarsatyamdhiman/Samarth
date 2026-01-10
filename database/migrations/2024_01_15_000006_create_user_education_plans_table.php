<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_education_plans', function (Blueprint $table) {
            $table->id();
$table->foreignId('user_id')->constrained('samarth_users')->onDelete('cascade');
            $table->foreignId('profile_id')->constrained('user_education_profiles')->onDelete('cascade');
            $table->string('plan_type'); // stream_selection, career_path, exam_preparation
            $table->json('recommended_streams')->nullable(); // Array of stream IDs
            $table->json('recommended_sectors')->nullable(); // Array of sector IDs
            $table->json('recommended_courses')->nullable(); // Array of course IDs
            $table->json('recommended_exams')->nullable(); // Array of exam IDs
            $table->json('plan_data')->nullable(); // Detailed plan structure
            $table->json('progress')->nullable(); // User progress tracking
            $table->json('milestones')->nullable(); // Key milestones and deadlines
            $table->json('study_schedule')->nullable(); // Daily/weekly/monthly schedule
            $table->json('resources')->nullable(); // Recommended resources and links
            $table->text('personalized_message_hindi')->nullable();
            $table->text('personalized_message_english')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_education_plans');
    }
};
