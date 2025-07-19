<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_safety_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_shift_entry_id')->constrained('daily_shift_entries')->cascadeOnDelete();
            $table->enum('question_number', ['question_one', 'question_two']);
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_safety_reviews');
    }
};
