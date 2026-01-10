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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('avatar');
            $table->string('language_preference')->default('hi')->after('preferred_language');
            $table->json('notification_preferences')->nullable()->after('language_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'language_preference', 'notification_preferences']);
        });
    }
};
