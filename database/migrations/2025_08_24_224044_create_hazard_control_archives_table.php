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
        Schema::create('hazard_control_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_log_archive_id');
            $table->unsignedBigInteger('fatality_risk_archive_id');
//            $table->foreignId('shift_log_archive_id')->constrained('shift_log_archives')->cascadeOnDelete();
//            $table->foreignId('fatality_risk_archive_id')->constrained('fatality_risk_archives')->cascadeOnDelete();
            $table->foreign('shift_log_archive_id', 'fk_hca_shift_log_archive')
                ->references('id')
                ->on('shift_log_archives')
                ->cascadeOnDelete();

            $table->foreign('fatality_risk_archive_id', 'fk_hca_fatality_risk_archive')
                ->references('id')
                ->on('fatality_risk_archives')
                ->cascadeOnDelete();


            $table->longText('description');
            $table->boolean('is_manual_entry')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_control_archives');
    }
};
