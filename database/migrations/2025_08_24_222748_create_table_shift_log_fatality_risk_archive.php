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
        Schema::create('shift_log_fatality_risk_archive', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_log_archive_id')->constrained('shift_log_archives')->cascadeOnDelete();
            $table->foreignId('fatality_risk_archive_id')->constrained('fatality_risk_archives')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_shift_log_fatality_risk_archive');
    }
};
