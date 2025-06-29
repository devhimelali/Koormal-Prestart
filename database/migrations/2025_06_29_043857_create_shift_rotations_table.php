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
        Schema::create('shift_rotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('week_index');
            $table->foreignId('day_shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('night_shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_rotations');
    }
};
