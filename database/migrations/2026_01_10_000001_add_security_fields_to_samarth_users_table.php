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
        Schema::table('samarth_users', function (Blueprint $table) {
            $table->string('security_question')->default('school')->after('two_factor_enabled');
            $table->string('security_answer')->nullable()->after('security_question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('samarth_users', function (Blueprint $table) {
            $table->dropColumn(['security_question', 'security_answer']);
        });
    }
};

