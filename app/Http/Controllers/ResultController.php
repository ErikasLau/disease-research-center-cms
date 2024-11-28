<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ExaminationStatus;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'unique:results,examination_id'],
            'excerpt' => ['required'],
        ]);

        $user = Auth::user();
        $examination = Examination::where('id', $request->id)->firstOrFail();

        Result::create([
            'excerpt' => $request->excerpt,
            'user_id' => $user->id,
            'examination_id' => $examination->id
        ]);

        $examination->status = ExaminationStatus::SENT_TO_CONFIRM->name;
        $examination->save();

        return redirect()->back();
    }
}
