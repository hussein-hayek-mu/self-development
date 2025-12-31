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
        Schema::create('guilds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // Unique URL-friendly identifier
            $table->text('description');
            $table->string('icon')->nullable();
            $table->integer('member_count')->default(0);
            $table->integer('max_members')->default(100);
            $table->integer('total_xp')->default(0);
            $table->boolean('is_public')->default(true);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); //owner_id references the id column in the users table...way we used : shorthand for foreign key
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guilds');
    }
};
