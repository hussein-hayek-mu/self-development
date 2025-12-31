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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email'); // 'user' or 'admin'
            $table->boolean('is_banned')->default(false)->after('role');
            $table->timestamp('banned_at')->nullable()->after('is_banned');
            $table->timestamp('last_login_at')->nullable()->after('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_banned', 'banned_at', 'last_login_at']);
        });
    }
};
