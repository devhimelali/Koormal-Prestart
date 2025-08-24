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
        Schema::create('site_communication_archives', function (Blueprint $table) {
            $table->id();
            $table->string('crew');
            $table->string('shift_rotation');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('shift_type');
            $table->date('date');
            $table->string('path');
            $table->string('title');
            $table->longText('description');
            $table->string('supervisor_name');
            $table->string('labour_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_communication_archives');
    }
};
