<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Role;
use App\Models\User;
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

        User::factory()->count(20)->create();

        User::factory()->count(20)->create(['role' => Role::DOCTOR]);
        User::factory()->count(20)->create(['role' => Role::LABORATORIAN]);

        $doctors = User::where('role', Role::DOCTOR)->get();

        foreach ($doctors as $doctor) {
            $doctorSpecialization = DoctorSpecialization::factory()->create();

            $doctor = Doctor::factory()->create(['user_id' => $doctor->id, 'doctor_specialization_id' => $doctorSpecialization->id]);

            WorkSchedule::factory()->create(['doctor_id' => $doctor->id]);
        }
    }
}
