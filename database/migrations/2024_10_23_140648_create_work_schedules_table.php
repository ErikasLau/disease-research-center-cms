<?php

use App\Models\WeekDays;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->time('shift_start_time');
            $table->time('shift_end_time');
            $table->date('shift_start_date');
            $table->date('shift_end_date');
            $table->enum('days_of_week', WeekDays::getOptions());

            $table->foreignUlid('doctor_id')->nullable()->references('id')->on('doctors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
