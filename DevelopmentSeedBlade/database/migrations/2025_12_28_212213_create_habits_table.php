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
            $table->integer('xp_reward')->default(50);
            $table->integer('current_streak')->default(0);
            $table->integer('best_streak')->default(0);
            $table->integer('total_completions')->default(0);
            $table->boolean('is_active')->default(true);
            $table->enum('frequency', ['daily', 'weekly', 'monthly'])->default('daily'); //Creates a column named frequency that can only accept these three specific values
            $table->string('icon')->nullable();
            $table->string('color')->default('#a855f7');
            $table->timestamps();
            $table->index('user_id');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
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
