<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Models\Examination;
use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    if (Auth::user()->role == Role::LABORATORIAN->name) {
        return view('dashboard.laborant-dashboard');
    } elseif (Auth::user()->role == Role::DOCTOR->name) {
        return view('dashboard.doctor-dashboard');
    } elseif (Auth::user()->role == Role::ADMIN->name) {
        return view('dashboard.admin-dashboard');
    } else {
        return view('dashboard.patient-dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/examination/{id}', function (string $id) {
    $examination = Examination::where('id', $id)->with('patient.user')->with('result')->with('visit.doctor.user')->firstOrFail();

    return view('examination.examination', compact('examination'));
});

Route::get('/patients', function () {
    return view('patient.patients');
})->name('patients');

Route::get('/patient/{id}', function (string $id) {
    $patient = User::where('id', $id)->where('role', Role::PATIENT->name)->firstOrFail();

    return view('patient.patient', compact('patient'));
})->whereUlid('id');

Route::get('/doctors', function () {
    return view('doctor.doctors');
})->name('doctors');

Route::get('/doctor/create', function () {
    return view('doctor.create-doctor');
})->middleware(['auth', 'restrictRole:' . Role::ADMIN->name])->name('create-doctor');

Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.store');

Route::get('/doctor/{id}', function (string $id) {
    $doctor = User::where('id', $id)->where('role', Role::DOCTOR->name)->firstOrFail();

    return view('doctor.doctor', compact('doctor'));
})->name('doctor');

Route::get('/laboratorians', function () {
    return view('laboratorian.laboratorians');
})->name('laboratorians');

Route::get('/laboratorian/{id}', function (string $id) {
    $laboratorian = User::where('id', $id)->where('role', Role::LABORATORIAN)->firstOrFail();

    return view('laboratorian.laboratorian', compact('laboratorian'));
})->name('laboratorian');

Route::get('/visit/{id}', function (string $id) {
    $visit = Visit::where('id', $id)->with('doctor.user')->with('doctor.specialization')->with('patient.user')->firstOrFail();

    return view('visit.visit', compact('visit'));
})->name('visit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
