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
use App\Models\DoctorAppointmentSlot;
use App\Models\DoctorSpecialization;
use App\Models\Examination;
use App\Models\ExaminationStatus;
use App\Models\Patient;
use App\Models\Result;
use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitStatus;
use App\Models\WeekDays;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    if (Auth::user()->role == Role::LABORATORIAN->name) {
        $examinations = Examination::take(8)
            ->orderBy("created_at", "DESC")
            ->get();

        return view('dashboard.laborant-dashboard', compact('examinations'));
    } elseif (Auth::user()->role == Role::DOCTOR->name) {
        $doctor = Auth::user()->doctor;

        $visits = Visit::orderBy("visit_date", "desc")
            ->where("doctor_id", $doctor->id)
            ->take(8)
            ->get();

        $examinations = Examination::where("status", ExaminationStatus::SENT_TO_CONFIRM->name)
            ->whereHas("visit", function ($query) use ($doctor) {
                $query->where("doctor_id", $doctor->id);
            })
            ->orderBy("created_at", "desc")
            ->take(8)
            ->get();

        return view('dashboard.doctor-dashboard', compact('visits', 'examinations'));
    } elseif (Auth::user()->role == Role::ADMIN->name) {
        $patients_count = Patient::count();
        $doctors_count = Doctor::count();
        $laboratorians_count = User::where("role", Role::LABORATORIAN->name)->count();
        $admins_count = User::where("role", Role::ADMIN->name)->count();

        $visits_count = Visit::count();
        $examinations_count = Examination::count();
        $results_count = Result::count();

        return view('dashboard.admin-dashboard', compact('patients_count', 'doctors_count', 'laboratorians_count', 'admins_count', 'visits_count', 'examinations_count', 'results_count'));
    } else {
        $patient = Patient::where("user_id", Auth::id())->first();

        $completedVisits = Visit::where("patient_id", $patient->id)
            ->where(function ($query) {
                $query->where("visit_date", "<=", date("Y-m-d"))->orWhere("status", VisitStatus::COMPLETED->name);
            })
            ->orderBy("visit_date", "desc")
            ->take(4)
            ->get();

        $createdVisits = Visit::where("patient_id", $patient->id)
            ->where("patient_id", $patient->id)
            ->where("visit_date", ">=", date("Y-m-d", strtotime("now")))
            ->where("status", VisitStatus::CREATED->name)
            ->orderBy("visit_date", "ASC")
            ->take(4)
            ->get();

        $nextTime = DB::table("doctor_appointment_slots")
            ->select(DB::raw("MIN(start_time) as start_time"), "doctor_id")
            ->where("doctor_appointment_slots.start_time", ">=", date("Y-m-d H:i", strtotime("now")))
            ->where("doctor_appointment_slots.is_available", true)
            ->groupBy("doctor_appointment_slots.doctor_id");

        $users = DB::table("users")
            ->where("role", Role::DOCTOR->name)
            ->select("users.name", "doctor_specializations.name as specialization_name", "next_time.start_time", "doctors.id as doctor_id")
            ->join("doctors", function (JoinClause $join) {
                $join->on("users.id", "=", "doctors.user_id");
            })
            ->join("doctor_specializations", function (JoinClause $join) {
                $join->on("doctors.doctor_specialization_id", "=", "doctor_specializations.id");
            })
            ->rightJoinSub($nextTime, "next_time", function (JoinClause $join) {
                $join->on("doctor_id", "=", "doctors.id");
            })
            ->orderBy("next_time.start_time", "ASC")
            ->take(8)
            ->get();

        return view('dashboard.patient-dashboard', compact('completedVisits', 'createdVisits', 'users'));
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
        if (Auth::user()->patient) {
            $patients = Patient::where("id", "!=", Auth::user()->patient->id)->paginate(15);
        } else {
            $patients = Patient::paginate(15);
        }

        return view('patient.patients', compact('patients'));
    })->name('patients');

    // All laboratorians page
    Route::get('/laboratorians', function () {
        $users = User::where("role", Role::LABORATORIAN->name)
            ->orderBy("created_at", "DESC")
            ->paginate(15);

        return view('laboratorian.laboratorians', compact('users'));
    })->name('laboratorians');

    Route::get('/doctor/create', function () {
        $specializations = DoctorSpecialization::all();
        $weekDays = WeekDays::values();

        $date = new DateTime("now", new DateTimeZone('Europe/Vilnius'));
        $oldSpecialization = old('specialization');

        return view('doctor.create', compact('specializations', 'weekDays', 'date', 'oldSpecialization'));
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
        $visits = Visit::where("patient_id", Auth::user()->patient->id)
            ->orderBy("visit_date", "DESC")
            ->take(8)
            ->get();
        $examinations = Examination::where("patient_id", Auth::user()->patient->id)
            ->take(8)
            ->get();

        return view('patient.treatment-history', compact('visits', 'examinations'));
    })->name('treatment-history');

    // Patient treatment history. All visits
    Route::get('patient/treatment-history/visits', function () {
        $visits = Visit::where("patient_id", Auth::user()->patient->id)
            ->orderBy("visit_date", "desc")
            ->paginate(15);

        return view('patient.treatment-history-visits', compact('visits'));
    })->name('treatment-history-visits');

    // Patient treatment history. All examinations
    Route::get('patient/treatment-history/examinations', function () {
        $examinations = Examination::where("patient_id", Auth::user()->patient->id)
            ->orderBy("created_at", "DESC")
            ->paginate(15);

        return view('patient.treatment-history-examinations', compact('examinations'));
    })->name('treatment-history-examinations');

    // Doctor possible visit times page
    Route::get('/doctor/{id}/visit', function (string $id) {
            $doctor = Doctor::where("id", $id)->first();
        $appointments = DoctorAppointmentSlot::where("doctor_id", $id)
            ->with("doctor.specialization")
            ->with("doctor.user")
            ->where("start_time", ">=", date("Y-m-d H:i", strtotime("now")))
            ->where("is_available", true)
            ->orderBy("start_time", "ASC")
            ->get();

        $unique_dates = [];
        foreach ($appointments as $appointment) {
            $appointment->start_time = date("Y-m-d H:i", strtotime($appointment->start_time));
            $date_only = date("Y-m-d", strtotime($appointment->start_time));
            $unique_dates[$date_only] = $date_only;
        }
        $unique_dates = array_values($unique_dates);

        return view('visit.create-visit', compact('id', 'doctor', 'appointments', 'unique_dates'));
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
            || ($visit->patient && $visit->patient->user_id == $user->id))) {
            return abort(404);
        }

        $visitStatus = VisitStatus::getOptions();
        $visitStatusToChange = [VisitStatus::CREATED->name, VisitStatus::CANCELED->name];

        return view('visit.visit', compact('visit', 'visitStatus', 'visitStatusToChange'));
    })->name('visit');
});

/**
 * DOCTORS PAGES
 */
Route::middleware(['auth', 'restrictRole:' . Role::DOCTOR->name])->group(function () {
    Route::get('/visits', function () {

        //Load visits
        $doctor = Auth::user()->doctor;
        $visits = Visit::where("doctor_id", $doctor->id)
            ->orderBy("visit_date", "DESC")
            ->paginate(15);

        return view('visit.visits', compact('visits'));
    })->name('visits');

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
            || ($doctor && $doctor->user_id == $user->id))) {
            return abort(404);
        }

        if (Auth::user()->role == Role::LABORATORIAN->name) {
            $visitStatus = VisitStatus::values();
            $examinationStatus = [ExaminationStatus::NOT_COMPLETED->name, ExaminationStatus::IN_PROGRESS->name];

            return view('examination.examination', compact('examination', 'visitStatus', 'examinationStatus'));
        }

        $visitStatus = VisitStatus::values();
        $examinationStatus = ExaminationStatus::getOptions();

        return view('examination.examination-doctor', compact('examination', 'visitStatus', 'examinationStatus'));
    });

    Route::get('/examinations', function () {
        $user = Auth::user();
        if ($user->role === Role::DOCTOR->name) {
            $doctor = Auth::user()->doctor;

            $examinations = Examination::whereHas("visit", function ($query) use ($doctor) {
                $query->where("doctor_id", $doctor->id);
            })
                ->orderBy("created_at", "DESC")
                ->paginate(15);
        } else {
            $examinations = Examination::orderBy("created_at", "DESC")->paginate(15);
        }

        return view('examination.examinations', compact('user', 'examinations'));
    })->name('examinations');
});

/**
 * SHARED PAGE BETWEEN PATIENTS AND ADMIN
 */
Route::get('/doctors', function () {
    if (Auth::user()->role == Role::PATIENT->name) {
        $nextTime = DB::table("doctor_appointment_slots")
            ->select(DB::raw("MIN(start_time) as start_time"), "doctor_id")
            ->where("doctor_appointment_slots.start_time", ">=", date("Y-m-d H:i", strtotime("now")))
            ->where("doctor_appointment_slots.is_available", true)
            ->groupBy("doctor_appointment_slots.doctor_id");

        $users = DB::table("users")
            ->where("role", Role::DOCTOR->name)
            ->select("users.name", "doctor_specializations.name as specialization_name", "next_time.start_time", "doctors.id as doctor_id")
            ->join("doctors", function (JoinClause $join) {
                $join->on("users.id", "=", "doctors.user_id");
            })
            ->join("doctor_specializations", function (JoinClause $join) {
                $join->on("doctors.doctor_specialization_id", "=", "doctor_specializations.id");
            })
            ->leftJoinSub($nextTime, "next_time", function (JoinClause $join) {
                $join->on("doctor_id", "=", "doctors.id");
            })
            ->orderByRaw("COALESCE(next_time.start_time, '9999-12-31 23:59:59') ASC")
            ->orderBy("specialization_name", "ASC")
            ->paginate(15);

        return view('doctor.doctors-patients', compact('users'));
    }

    $doctors = Doctor::orderBy("created_at", "DESC")->paginate(15);

    return view('doctor.doctors', compact('doctors'));
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
