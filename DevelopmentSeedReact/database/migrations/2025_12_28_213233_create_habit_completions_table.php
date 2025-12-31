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
        Schema::create('habit_completions', function (Blueprint $table) {
            $table->id();
            $table->date('completion_date');
            $table->integer('xp_earned');
            $table->text('notes')->nullable();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->index(['user_id', 'completion_date']);//Faster queries when searching/filtering by BOTH columns or just user_id
            $table->unique(['habit_id', 'completion_date']); //Creates a composite unique constraint - the combination of habit_id and completion_date must be unique across the entire table.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_completions');
    }
};
