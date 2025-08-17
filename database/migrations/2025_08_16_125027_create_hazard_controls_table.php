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
        Schema::create('hazard_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_log_id');
            $table->foreignId('fatality_risk_id')->constrained('fatality_risks')->cascadeOnDelete();
            $table->longText('description');
            $table->boolean('is_manual_entry')->default(false);
            $table->timestamps();

            $table->index('shift_log_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_controls');
    }
};
