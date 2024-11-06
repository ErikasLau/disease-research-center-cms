<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Doctor;
use App\Models\DoctorAppointmentSlot;
use App\Models\DoctorSpecialization;
use App\Models\Examination;
use App\Models\Patient;
use App\Models\Result;
use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use App\Models\WorkSchedule;
use App\Services\ScheduleService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'role' => Role::ADMIN->name,
        ]);

        $patients = User::factory()->count(20)->create(['role' => Role::PATIENT->name]);

        foreach ($patients as $patient) {
            Patient::factory()->create(['user_id' => $patient->id]);
        }

        $laboratorians = User::factory()->count(20)->create(['role' => Role::LABORATORIAN->name]);

        $doctors = User::factory()->count(20)->create(['role' => Role::DOCTOR->name]);

        $insertedAppointments = [];
        foreach ($doctors as $doctor) {
            $doctorSpecialization = DoctorSpecialization::factory()->create();

            $doctor = Doctor::factory()->create(['user_id' => $doctor->id, 'doctor_specialization_id' => $doctorSpecialization->id]);

            $schedule = WorkSchedule::factory()->create(['doctor_id' => $doctor->id]);
            $appointments = (new ScheduleService)->convertWorkScheduleToAppointments($schedule, $doctor->id);

            foreach ($appointments as $appointment) {
                $appointment->save();
                $insertedAppointments[] = $appointment;
            }
        }

        $visits = Visit::factory()->count(5)->create(['doctor_id' => $doctors[0]->doctor->id, 'patient_id' => $patients[0]->patient->id, 'doctor_appointment_slot_id' => $insertedAppointments[0]->id]);
        $examinations = Examination::factory()->count(5)->create(['patient_id' => $patients[0]->patient->id, 'visit_id' => $visits[0]->id]);
        $results = Result::factory()->count(5)->create(['user_id' => $laboratorians[0]->id, 'examination_id' => $examinations[0]->id]);
        Comment::factory()->count(5)->create(['result_id' => $results[0]->id, 'doctor_id' => $doctors[0]->doctor->id]);
    }
}
