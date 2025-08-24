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
        Schema::create('fatal_risk_to_discuss_control_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatal_risk_to_discuss_archive_id')->constrained('fatal_risk_to_discuss_archives')->cascadeOnDelete();
            $table->text('description');
            $table->boolean('is_manual_entry')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatal_risk_to_discuss_control_archives');
    }
};
