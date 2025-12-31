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
        Schema::create('achievements', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('slug')->unique();
            // $table->text('description');
            // $table->string('icon');
            // $table->integer('xp_reward')->default(0);
            // $table->string('requirement_type'); //'quests_completed', 'level', 'streak', etc.
            // $table->integer('required_value'); //number of quests, level number, days in streak, etc.
            // $table->boolean('is_hidden')->default(false);
            // $table->timestamps();
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon');
            $table->integer('xp_reward')->default(0);
            $table->string('requirement_type');
            $table->integer('requirement_value')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
