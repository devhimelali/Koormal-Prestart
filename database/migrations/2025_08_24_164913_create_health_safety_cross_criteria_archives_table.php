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
        Schema::create('health_safety_cross_criteria_archives', function (Blueprint $table) {
            $table->id();
            $table->string('criteria_name');
            $table->text('criteria_description');
            $table->string('criteria_color');
            $table->string('criteria_bg_color');
            $table->string('crew');
            $table->string('shift_rotation');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('shift_type');
            $table->date('date');
            $table->string('cell_number')->nullable();
            $table->string('supervisor_name');
            $table->text('labour_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_safety_cross_criteria_archives');
    }
};
