<?php

namespace App\Rules;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\VisitStatus;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Translation\PotentiallyTranslatedString;

class VisitUniqueToUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
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
            ->where('status', '!=', VisitStatus::CANCELED->name)
            ->where('status', '!=', VisitStatus::COMPLETED->name)
            ->where('doctor_id', $doctorId)
            ->where('visit_date', '>=', now())
            ->first();

        if ($existingVisit) {
            $fail("Jūs jau esate užsiregistravęs(-a) vizitui pas šį gydytoją.");
        }

        $newStartTime = Carbon::parse($value->start_time)->subMinutes(30);
        $visitAtThatTime = Visit::where('patient_id', $patient->id)
            ->where('status', '!=', VisitStatus::CANCELED->name)
            ->where('status', '!=', VisitStatus::COMPLETED->name)
            ->whereBetween('visit_date', [$newStartTime, $value->end_time])
            ->first();

        if ($visitAtThatTime) {
            $fail("Šiuo laiku jūs jau turite kitą vizitą.");
        }
    }
}
