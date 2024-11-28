<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Role;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'examination_type' => ['required', 'min:3', 'max:100'],
            'examination_comment' => ['required', 'min:5', 'max:750'],
        ]);

        $visit = Visit::findOrFail($request->id);

        Examination::create([
            'type' => $request->examination_type,
            'comment' => $request->examination_comment,
            'patient_id' => $visit->patient_id,
            'visit_id' => $visit->id,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => ['required'],
        ]);

        if (!$id) {
            return back()->withErrors(['visit_status' => __('Įvyko klaida apdorojant jūsų užklausą.')]);
        }

        $examination = Examination::where('id', $id)->firstOrFail();

        if (Auth::user()->role != Role::LABORATORIAN->name) {
            return back()->withErrors(['status' => 'Jūs turite būti laborantas norėdamas atnaujinti tyrimo informaciją.']);
        }

        $examination->status = $request->status;
        $examination->save();

        return back();
    }
}
