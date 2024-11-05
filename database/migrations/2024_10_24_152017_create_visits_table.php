<?php

use App\Models\VisitStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->dateTime('visit_date');
            $table->enum('status', VisitStatus::getOptions())->default(VisitStatus::CREATED->name);

            $table->foreignUlid('doctor_id')->references('id')->on('doctors');
            $table->foreignUlid('patient_id')->references('id')->on('patients');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
