<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitController;
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
})->middleware(['auth'])->name('dashboard');

/**
 * PROFILE PAGES
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ADMIN PAGES
 */
Route::middleware(['auth', 'restrictRole:' . Role::ADMIN->name])->group(function () {
    // All patients page
    Route::get('/patients', function () {
        return view('patient.patients');
    })->name('patients');

    // All laboratorians page
    Route::get('/laboratorians', function () {
        return view('laboratorian.laboratorians');
    })->name('laboratorians');

    // Post doctor with doctor work schedules
    Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.create');
});

/**
 * PATIENT PAGES
 */
Route::middleware(['auth', 'restrictRole:' . Role::PATIENT->name])->group(function () {
    // Patient treatment history
    Route::get('patient/treatment-history', function () {
        return view('patient.treatment-history');
    })->name('treatment-history');

    // Patient treatment history. All visits
    Route::get('patient/treatment-history/visits', function () {
        return view('patient.treatment-history-visits');
    })->name('treatment-history-visits');

    // Patient treatment history. All examinations
    Route::get('patient/treatment-history/examinations', function () {
        return view('patient.treatment-history-examinations');
    })->name('treatment-history-examinations');

    // Doctor possible visit times page
    Route::get('/doctor/{id}/visit', function (string $id) {
        return view('visit.create-visit', compact('id'));
    })->name('create-visit');

    // Create visit
    Route::post('/visit', [VisitController::class, 'store'])->name('visit.create');
});

/**
 * SHARED PAGES BETWEEN PATIENT AND DOCTOR
 */
Route::middleware(['auth', 'restrictRole:' . Role::PATIENT->name . ',' . Role::DOCTOR->name])->group(function () {
    // Edit post status
    Route::patch('/visit/{id}', [VisitController::class, 'update'])->name('visit.update');

    Route::get('/doctors', function () {
        if (Auth::user()->role == Role::PATIENT->name) {
            return view('doctor.doctors-patients');
        }

        return view('doctor.doctors');
    })->name('doctors');

    Route::get('/visit/{id}', function (string $id) {
        $visit = Visit::where('id', $id)->with('doctor.user')->with('doctor.specialization')->with('patient.user')->with('examination.result')->firstOrFail();

        return view('visit.visit', compact('visit'));
    })->name('visit');

    Route::get('/visits', function () {
        return view('visit.visits');
    })->name('visits');
});

/**
 * DOCTORS PAGES
 */
Route::middleware(['auth', 'restrictRole:' . Role::DOCTOR->name])->group(function () {
    Route::post('/examination/create', [ExaminationController::class, 'store'])->name('examination.store');
    Route::post('/comment/create', [CommentController::class, 'store'])->name('comment.store');
});

/**
 * SHARED PAGES BETWEEN LABORATORIAN AND DOCTOR
 */
Route::middleware(['auth', 'restrictRole:' . Role::LABORATORIAN->name . ',' . Role::DOCTOR->name])->group(function () {
    Route::get('/examination/{id}', function (string $id) {
        $examination = Examination::where('id', $id)->with('patient.user')->with('result')->with('visit.doctor.user')->firstOrFail();

        if (Auth::user()->role == Role::LABORATORIAN->name) {
            return view('examination.examination', compact('examination'));
        }

        return view('examination.examination-doctor', compact('examination'));
    });

    Route::get('/examinations', function () {
        return view('examination.examinations');
    })->name('examinations');
});

Route::get('/patient/{id}', function (string $id) {
    $patient = User::where('id', $id)->where('role', Role::PATIENT->name)->firstOrFail();

    return view('patient.patient', compact('patient'));
})->whereUlid('id');

Route::get('/doctor/{id}', function (string $id) {
    $doctor = User::where('id', $id)->where('role', Role::DOCTOR->name)->fist();

    return view('doctor.doctor', compact('doctor'));
})->name('doctor');

Route::get('/laboratorian/{id}', function (string $id) {
    $laboratorian = User::where('id', $id)->where('role', Role::LABORATORIAN)->firstOrFail();

    return view('laboratorian.laboratorian', compact('laboratorian'));
})->name('laboratorian');

require __DIR__ . '/auth.php';
