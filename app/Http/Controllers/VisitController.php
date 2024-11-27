<?php

namespace App\Http\Controllers;

use App\Models\DoctorAppointmentSlot;
use App\Models\Patient;
use App\Models\Role;
use App\Models\Visit;
use App\Models\VisitStatus;
use App\Rules\VisitUniqueToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    //
    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        if (!$id) {
            return back()->withErrors(['visit_status' => __('Įvyko klaida apdorojant jūsų užklausą.')]);
        }

        $visit = Visit::where('id', $id)->firstOrFail();

        switch (Auth::user()->role) {
            case Role::PATIENT->name:
                if ($request->visit_status === VisitStatus::CANCELED->name) {
                    $errors = $this->cancelVisit($visit, $visit->doctorAppointmentSlot);
                    if (count($errors) > 0) return back()->withErrors($errors);
                } else {
                    return back()->withErrors(['visit_status' => __('Vizito statuso pakeisti nepavyko.')]);
                }
                break;
            case Role::DOCTOR->name:
                switch ($request->visit_status) {
                    case VisitStatus::CANCELED->name:
                        $errors = $this->cancelVisit($visit, $visit->doctorAppointmentSlot);
                        if (count($errors) > 0) return back()->withErrors($errors);
                        break;
                    default:
                        $visit->status = $request->visit_status;
                        $visit->save();
                }
                break;
        }

        return back();
    }

    private function cancelVisit(Visit $visit, DoctorAppointmentSlot $appointment)
    {
        if ($visit->examination || strtotime($visit->visit_date) <= strtotime(now())) {
            return ['visit_status' => __('Vizitas jau pradėtas vykdyti, jo atšaukti negalima.')];
        }

        $appointment->is_available = true;
        $visit->status = VisitStatus::CANCELED->name;
        $visit->doctor_appointment_slot_id = null;

        $appointment->save();
        $visit->save();

        return [];
    }
}
