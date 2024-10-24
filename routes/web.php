<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/create-doctor', function () {
    return view('admin.create-doctor');
});

Route::get('/patients', function () {
    return view('patient.patients');
})->name('patients');

Route::get('/patient/{id}', function (string $id) {
    $patient = User::where('id', $id)->where('role', \App\Models\Role::PATIENT)->firstOrFail();

    return view('patient.patient', compact('patient'));
})->whereUlid('id');

Route::get('/doctors', function () {
    return view('doctor.doctors');
})->name('doctors');

Route::get('/doctor/create', function () {
    return view('doctor.create-doctor');
})->name('create-doctor');

Route::get('/doctor/{id}', function (string $id) {
    $doctor = User::where('id', $id)->where('role', \App\Models\Role::DOCTOR)->firstOrFail();

    return view('doctor.doctor', compact('doctor'));
})->name('doctor');

Route::get('/laboratorians', function () {
    return view('laboratorian.laboratorians');
})->name('laboratorians');

Route::get('/laboratorian/{id}', function (string $id) {
    $laboratorian = User::where('id', $id)->where('role', \App\Models\Role::LABORATORIAN)->firstOrFail();

    return view('laboratorian.laboratorian', compact('laboratorian'));
})->name('laboratorian');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
