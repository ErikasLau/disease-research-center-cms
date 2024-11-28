<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LaboratorianController extends Controller
{

    //
    public function store(Request $request)
    {
        $request->validate([
                'name' => ['required', 'string', 'max:80'],
                'birth_date' => ['required', 'date', 'before_or_equal:18 years ago'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone_number' => ['required', 'regex:/^\+(?:[0-9] ?){9,12}[0-9]$|^([0-9]{10,12})$|^([0-9]{9})$|^0([0-9]{9})$/', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]
        );


        User::create([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => Role::LABORATORIAN->name
        ]);

        return redirect(route('laboratorians', absolute: false));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);

        $user = User::where('id', $request->id)->firstOrFail();

        $user->delete();

        return redirect()->back()->with('success', 'Laborantas ' . $user->name . ' pašalintas sėkmingai.');
    }
}
