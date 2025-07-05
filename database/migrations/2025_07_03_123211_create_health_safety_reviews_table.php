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
            $table->date('date');
            $table->enum('shift_type', ['day', 'night']);
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('rotation_id')->constrained('shift_rotations')->cascadeOnDelete();
            $table->string('supervisor_name')->nullable();
            $table->text('question_1')->nullable();
            $table->string('question_1_audio')->nullable();
            $table->text('question_2')->nullable();
            $table->string('question_2_audio')->nullable();
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
