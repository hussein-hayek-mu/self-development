<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['daily', 'weekly', 'monthly', 'boss'])->default('daily');
            $table->enum('difficulty', ['easy', 'medium', 'hard', 'epic'])->default('medium');
            $table->integer('xp_reward');
            $table->enum('status', ['active', 'completed', 'failed', 'archived'])->default('active');
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('progress')->default(0);
            $table->integer('target')->default(1);
            $table->string('icon')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('due_date');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
