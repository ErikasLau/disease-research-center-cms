<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
                'name' => ['required', 'string', 'max:40'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'phone_number' => ['required', 'regex:/^\+(?:[0-9] ?){9,12}[0-9]$|^([0-9]{10,12})$|^([0-9]{9})$|^0([0-9]{9})$/', 'unique:' . User::class],
                'birth_date' => ['required', 'date', 'before_or_equal:18 years ago'],
            ]
        );

        $request->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
        ]);

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
