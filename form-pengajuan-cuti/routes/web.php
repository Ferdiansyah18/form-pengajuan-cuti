<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'hrd' || $role === 'security') {
        return redirect()->route('hrd.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:hrd|security'])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\HrdController::class, 'dashboard'])->name('dashboard');
    Route::get('/review/{id}', [\App\Http\Controllers\HrdController::class, 'show'])->name('review');
    Route::put('/review/{id}', [\App\Http\Controllers\HrdController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/apply', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('apply');
    Route::post('/apply', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
