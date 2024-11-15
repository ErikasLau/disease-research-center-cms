<?php

namespace App\Http\Controllers;

use App\Models\DoctorAppointmentSlot;
use App\Models\Patient;
use App\Models\Visit;
use App\Rules\VisitUniqueToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    //
    public function store(Request $request){

        $appointment = DoctorAppointmentSlot::where('id', $request->id)->firstOrFail();
        $user = Auth::user();

        $request->merge(['appointment' => $appointment]);

        $request->validate([
            'id' => ['required', 'unique:visits,doctor_appointment_slot_id'],
            'appointment' => ['required', new VisitUniqueToUser],
        ]);

        $appointment->is_available = false;
        $patient = Patient::where('user_id', $user->id)->first();

        $visit = Visit::create([
            'visit_date' => $appointment->start_time,
            'doctor_id' => $appointment->doctor->id,
            'patient_id' => $patient->id,
            'doctor_appointment_slot_id' => $appointment->id,
        ]);

        $appointment->save();

        return redirect('/visit/' . $visit->id);
    }
}
