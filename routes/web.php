<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\LaboratorianController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\VisitController;
use App\Models\Doctor;
use App\Models\Examination;
use App\Models\Patient;
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

    Route::get('/doctor/create', function () {
        return view('doctor.create');
    })->name('doctor.create');

    // Post doctor with doctor work schedules
    Route::post('/doctor/create', [DoctorController::class, 'store'])->name('doctor.create');

    Route::get('/laboratorian/create', function () {
        return view('laboratorian.create');
    })->name('laboratorian.create');

    Route::post('/laboratorian/create', [LaboratorianController::class, 'store'])->name('laboratorian.create');

    Route::delete('/patient', [PatientController::class, 'delete'])->name('patient.delete');
    Route::delete('/doctor', [DoctorController::class, 'delete'])->name('doctor.delete');
    Route::delete('/laboratorian', [LaboratorianController::class, 'delete'])->name('laboratorian.delete');
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

    Route::get('/visit/{id}', function (string $id) {
        $user = Auth::user();
        $visit = Visit::where('id', $id)->firstOrFail();

        if (!($user->role == Role::ADMIN->name || $user->role == Role::LABORATORIAN->name || ($visit->doctor && $visit->doctor->user_id == $user->id)
        || ($visit->patient && $visit->patient->user_id == $user->id))){
            return abort(404);
        }

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
        $user = Auth::user();
        $examination = Examination::where('id', $id)->firstOrFail();

        $doctor = Doctor::where('id', $examination->visit->doctor_id)->first();
        $patient = Patient::where('id', $examination->visit->patient_id)->first();

        if (!($user->role == Role::ADMIN->name || $user->role == Role::LABORATORIAN->name || ($patient && $patient->user_id == $user->id)
            || ($doctor && $doctor->user_id == $user->id))){
            return abort(404);
        }

        if (Auth::user()->role == Role::LABORATORIAN->name) {
            return view('examination.examination', compact('examination'));
        }

        return view('examination.examination-doctor', compact('examination'));
    });

    Route::get('/examinations', function () {
        return view('examination.examinations');
    })->name('examinations');
});

/**
 * SHARED PAGE BETWEEN PATIENTS AND ADMIN
 */
Route::get('/doctors', function () {
    if (Auth::user()->role == Role::PATIENT->name) {
        return view('doctor.doctors-patients');
    }

    return view('doctor.doctors');
})->middleware(['auth', 'restrictRole:' . Role::LABORATORIAN->name . ',' . Role::ADMIN->name . ',' . Role::PATIENT->name])->name('doctors');

/**
 * LABORATORIAN PAGES
 */
Route::middleware(['auth', 'restrictRole:' . Role::LABORATORIAN->name])->group(function () {
    Route::patch('/examination/{id}', [ExaminationController::class, 'update'])->name('examination.update');
    Route::post('/result/create', [ResultController::class, 'store'])->name('result.store');
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
