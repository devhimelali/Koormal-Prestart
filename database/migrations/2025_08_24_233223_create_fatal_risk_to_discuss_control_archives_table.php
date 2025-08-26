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
            $table->unsignedBigInteger('fatal_risk_to_discuss_archive_id');
            $table->index('fatal_risk_to_discuss_archive_id', 'frtda_idx');
            $table->foreign('fatal_risk_to_discuss_archive_id', 'frtda_fk')
                ->references('id')
                ->on('fatal_risk_to_discuss_archives')
                ->cascadeOnDelete();
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
        Schema::table('fatal_risk_to_discuss_control_archives', function (Blueprint $table) {
            if (Schema::hasColumn('fatal_risk_to_discuss_control_archives', 'fatal_risk_to_discuss_archive_id')) {
                $table->dropForeign('frtda_fk');
                $table->dropIndex('frtda_idx');
            }
        });

        Schema::dropIfExists('fatal_risk_to_discuss_control_archives');
    }
};
