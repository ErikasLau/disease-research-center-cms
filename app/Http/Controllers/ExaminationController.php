<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Visit;
use Illuminate\Http\Request;

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
}
