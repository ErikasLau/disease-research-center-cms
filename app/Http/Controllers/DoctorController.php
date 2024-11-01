<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //
    public function store(Request $request): void
    {
        var_dump($request->timetables);
    }
}
