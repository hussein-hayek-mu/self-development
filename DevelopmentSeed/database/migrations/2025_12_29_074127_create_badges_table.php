<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon');
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary'])->default('common');
            $table->integer('required_value')->nullable();
            $table->string('requirement_type')->nullable(); 
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
