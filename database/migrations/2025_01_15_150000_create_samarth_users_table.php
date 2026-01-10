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
        // Create samarth_users table (primary user table for authentication)
        Schema::create('samarth_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->enum('role', ['user', 'admin', 'moderator'])->default('user');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('language')->default('hindi');
            $table->json('preferences')->nullable();
            $table->boolean('is_terms_accepted')->default(false);
            $table->boolean('is_privacy_accepted')->default(false);
            $table->string('timezone')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Create user_profiles table
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('samarth_users')->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('avatar')->nullable();

            $table->string('preferred_language')->default('hindi');
            $table->timestamps();
        });



        // Create goals table
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('title_hindi');
            $table->string('title_english')->nullable();
            $table->text('description_hindi')->nullable();
            $table->text('description_english')->nullable();
            $table->string('category')->nullable();
            $table->string('target_age_group')->nullable();
            $table->integer('estimated_time_hours')->default(1);
            $table->integer('points_reward')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create challenges table
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title_hindi');
            $table->string('title_english')->nullable();
            $table->text('description_hindi')->nullable();
            $table->text('description_english')->nullable();
            $table->string('category')->nullable();
            $table->integer('estimated_time_minutes')->default(30);
            $table->integer('points_reward')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create user_progress table
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('samarth_users')->onDelete('cascade');
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->string('status')->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // Create user_challenges table
        Schema::create('user_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('samarth_users')->onDelete('cascade');
            $table->foreignId('challenge_id')->constrained('challenges')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('points_earned')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_challenges');
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('goals');

        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('samarth_users');
    }
};
