<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);

        $patient = Patient::where('id', $request->id)->firstOrFail();
        $user = $patient->user;

        $patient->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Pacientas ' . $user->name . ' pašalintas sėkmingai.');
    }
}
