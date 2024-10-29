<?php

use App\Models\ExaminationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('type');
            $table->enum('status', ExaminationStatus::getOptions())->default(ExaminationStatus::NOT_COMPLETED);
            $table->string('comment');

            $table->foreignUlid('patient_id')->references('id')->on('patients');
            $table->foreignUlid('result_id')->nullable()->references('id')->on('results');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
