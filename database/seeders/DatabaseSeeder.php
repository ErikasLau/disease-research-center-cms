<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Examination;
use App\Models\Patient;
use App\Models\Result;
use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.lt',
            'password' => 'test',
            'role' => Role::ADMIN,
        ]);

        $patients = User::factory()->count(20)->create(['role' => Role::PATIENT]);

        foreach ($patients as $patient) {
            Patient::factory()->create(['user_id' => $patient->id]);
        }

        $laboratorians = User::factory()->count(20)->create(['role' => Role::LABORATORIAN]);

        $doctors = User::factory()->count(20)->create(['role' => Role::DOCTOR]);

        foreach ($doctors as $doctor) {
            $doctorSpecialization = DoctorSpecialization::factory()->create();

            $doctor = Doctor::factory()->create(['user_id' => $doctor->id, 'doctor_specialization_id' => $doctorSpecialization->id]);

            WorkSchedule::factory()->create(['doctor_id' => $doctor->id]);
        }

        $visits = Visit::factory()->count(5)->create(['doctor_id' => $doctors[0]->doctor->id, 'patient_id' => $patients[0]->patient->id]);
        $examinations = Examination::factory()->count(5)->create(['patient_id' => $patients[0]->patient->id]);
        $results = Result::factory()->count(5)->create(['examination_id' => $examinations[0]->id, 'user_id' => $laboratorians[0]->id]);
        Comment::factory()->count(5)->create(['result_id' => $results[0]->id, 'doctor_id' => $doctors[0]->doctor->id]);
    }
}
