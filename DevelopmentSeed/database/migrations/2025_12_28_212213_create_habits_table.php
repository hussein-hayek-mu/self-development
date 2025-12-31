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
        Schema::create('habits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('xp_reward')->default(50);
            $table->enum('frequency', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->integer('times_completed')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('color')->default('#a855f7');
            $table->timestamps();
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habits');
    }
};
