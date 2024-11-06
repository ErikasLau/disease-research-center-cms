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
        Schema::create('doctor_appointment_slots', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('is_available');

            $table->foreignUlid('doctor_id')->references('id')->on('doctors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_appointment_slots');
    }
};
