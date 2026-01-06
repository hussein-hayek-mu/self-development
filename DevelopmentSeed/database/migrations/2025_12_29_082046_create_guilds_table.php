<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('guilds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->integer('member_count')->default(0);
            $table->integer('max_members')->default(100);
            $table->integer('total_xp')->default(0);
            $table->boolean('is_public')->default(true);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    

    
    public function down(): void
    {
        Schema::dropIfExists('guilds');
    }
};
