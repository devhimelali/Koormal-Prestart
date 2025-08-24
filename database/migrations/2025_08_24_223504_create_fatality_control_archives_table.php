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
        Schema::create('fatality_control_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatality_risk_archive_id')->constrained('fatality_risk_archives')->cascadeOnDelete();
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatality_control_archives');
    }
};
