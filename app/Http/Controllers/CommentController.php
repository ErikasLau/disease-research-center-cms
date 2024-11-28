<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Doctor;
use App\Models\ExaminationStatus;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'unique:comments,result_id'],
            'text' => ['required'],
        ]);

        $results = Result::where('id', $request->id)->firstOrFail();
        $user = Auth::user();

        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

        $examination = $results->examination;

        Comment::create([
            'text' => $request->text,
            'result_id' => $results->id,
            'doctor_id' => $doctor->id
        ]);

        $examination->status = ExaminationStatus::AT_DOCTOR->name;
        $examination->save();

        return redirect()->back();
    }
}
