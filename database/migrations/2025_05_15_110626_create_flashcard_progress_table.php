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
        Schema::create('flashcard_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('translation_id')->constrained('translations')->onDelete('cascade');
            $table->enum('status', ['known', 'unknown'])->default('unknown');
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();

            // Unique constraint for user_id and translation_id combination
            $table->unique(['user_id', 'translation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcard_progress');
    }
};
