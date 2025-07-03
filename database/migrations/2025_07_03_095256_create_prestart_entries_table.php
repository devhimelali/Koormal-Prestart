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
        Schema::create('prestart_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date');
            $table->enum('shift_type', ['day', 'night']);
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->string('supervisor_name');
            $table->text('safe_action')->nullable();
            $table->text('unsafe_issue')->nullable();
            $table->string('audio_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestart_entries');
    }
};
