<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/create-doctor', function () {
    return view('admin.create-doctor');
});

Route::get('/pacients', function () {
    return view('pacient.pacients');
})->name('pacients');

Route::get('/doctors', function () {
    return view('doctor.doctors');
})->name('doctors');

Route::get('/labaratorians', function () {
    return view('labaratorian.labaratorians');
})->name('labaratorians');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
