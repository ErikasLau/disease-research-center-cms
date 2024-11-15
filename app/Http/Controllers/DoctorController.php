<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use App\Models\WorkSchedule;
use App\Rules\Timetable;
use App\Rules\TimetableShiftTime;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DoctorController extends Controller
{

    //
    public function store(Request $request)
    {
        $timetables = json_decode($request->timetables, true);

        $request->merge(['timetables' => $timetables]);

        $request->validate([
                'name' => ['required', 'string', 'max:80'],
                'birth_date' => ['required', 'date', 'before_or_equal:18 years ago'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone_number' => ['required', 'regex:/^\+(?:[0-9] ?){9,12}[0-9]$|^([0-9]{10,12})$|^([0-9]{9})$|^0([0-9]{9})$/', 'unique:' . User::class],
                'licence' => ['required', 'max:9'],
                'specialization' => ['required'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'timetables' => ['array', 'required', new TimetableShiftTime, new Timetable],
                'timetables.*.shift_start_time' => ['required', 'string', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
                'timetables.*.shift_end_time' => ['required', 'string', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
                'timetables.*.job_start_date' => ['required', 'date'],
                'timetables.*.job_end_date' => ['required', 'date'],
                'timetables.*.week_days' => ['required', 'array'],
                'timetables.*.week_days.*' => ['required', 'integer', 'min:0', 'max:6'],
            ]
        );


        $user = User::create([
            'name' => $request->name . " " . $request->last_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'licence' => $request->licence,
            'password' => Hash::make($request->password),
            'role' => Role::DOCTOR->name
        ]);

        $doctor = Doctor::create([
            'license_number' => $request->licence,
            'user_id' => $user->id,
            'doctor_specialization_id' => $request->specialization
        ]);

        foreach ($timetables as $timetable) {
            foreach ($timetable['week_days'] as $day) {
                $schedule = WorkSchedule::create([
                    'shift_start_time' => $timetable['shift_start_time'],
                    'shift_end_time' => $timetable['shift_end_time'],
                    'shift_start_date' => $timetable['job_start_date'],
                    'shift_end_date' => $timetable['job_end_date'],
                    'days_of_week' => $day,
                    'doctor_id' => $doctor->id
                ]);

                $appointments = (new ScheduleService)->convertWorkScheduleToAppointments($schedule, $doctor->id);

                foreach ($appointments as $appointment) {
                    $appointment->save();
                }
            }
        }

        return redirect(route('doctors', absolute: false));
    }
}
