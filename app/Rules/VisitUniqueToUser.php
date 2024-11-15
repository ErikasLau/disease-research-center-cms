<?php

namespace App\Rules;

use App\Models\DoctorAppointmentSlot;
use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use App\Models\WorkSchedule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class VisitUniqueToUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $doctorId = $value->doctor->id;
        $user = Auth::user();

        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            $fail("Įvyko klaida validuojant jūsų paskyrą.");
        }

        $existingVisit = Visit::where('patient_id', $patient->id)
            ->where('doctor_id', $doctorId)
            ->where('visit_date', '>=', now())
            ->first();

        if ($existingVisit) {
            $fail("Jūs jau esate užsiregistravęs(-a) vizitui pas šį gydytoją.");
        }
    }
}
