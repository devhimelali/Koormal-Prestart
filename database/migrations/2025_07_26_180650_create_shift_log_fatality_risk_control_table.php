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
        Schema::create('shift_log_fatality_risk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_log_id');
            $table->unsignedBigInteger('fatality_risk_id');
            $table->timestamps();

            // Indexes for faster queries
            $table->index('shift_log_id');
            $table->index('fatality_risk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_log_fatality_risk');
    }
};
