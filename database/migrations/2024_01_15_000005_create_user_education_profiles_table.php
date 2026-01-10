<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_education_profiles', function (Blueprint $table) {
            $table->id();
$table->foreignId('user_id')->constrained('samarth_users')->onDelete('cascade');
            $table->string('current_class'); // 8, 9, 10, 11, 12, dropout
            $table->string('planned_stream')->nullable(); // science, commerce, arts, vocational, not_decided
            $table->json('interest_tags')->nullable(); // ["maths", "biology", "computers", etc.]
            $table->json('strengths_hindi')->nullable(); // Student's perceived strengths
            $table->json('strengths_english')->nullable();
            $table->json('challenges_hindi')->nullable(); // Areas where student needs support
            $table->json('challenges_english')->nullable();
            $table->string('family_support_level')->nullable(); // high, medium, low
            $table->string('financial_constraints')->nullable(); // yes, no, some
            $table->text('career_goals_hindi')->nullable();
            $table->text('career_goals_english')->nullable();
            $table->json('preferred_learning_style')->nullable(); // visual, auditory, kinesthetic
            $table->timestamp('profile_completed_at')->nullable();
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_education_profiles');
    }
};
