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
        Schema::create('health_safety_cross_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cross_criteria_id')->constrained('cross_criterias')->cascadeOnDelete();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('shift_rotation_id')->constrained('shift_rotations')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('shift_type');
            $table->date('date');
            $table->string('cell_number')->comment('Cell number in the safety calendar, e.g., 1-31 for days of the month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_safety_cross_criterias');
    }
};
