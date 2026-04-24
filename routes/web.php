<?php

use App\Http\Controllers\DepartementController;
use Illuminate\Support\Facades\Route;

// PAGE LOGIN
Route::get('/', function () {
    return view('login');
});

Route::post('login', function () {
    return 1;
})->name('login');

// DASHBOARD
Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->name('dashboard');

// DEPARTEMENTS
Route::prefix('departements')->group(function () {

    Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
    Route::get('/create', [DepartementController::class, 'create'])->name('departements.create');
    Route::post('/store', [DepartementController::class, 'store'])->name('departements.store');
    Route::get('/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
    Route::post('/update/{id}', [DepartementController::class, 'update'])->name('departements.update');
    Route::delete('/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');
    Route::get('/show/{id}', [DepartementController::class, 'show'])->name('departements.show');
});

// FINANCES
Route::prefix('finances')->group(function () {

    Route::get('/', function () {
        return view('auth.finances.show');
    })->name('finances.show');

    Route::get('/create', function () {
        return view('auth.finances.create');
    })->name('finances.create');

    Route::get('/update/{id}', function ($id) {
        return view('auth.finances.update');
    })->name('finances.update');

    Route::get('/delete/{id}', function ($id) {
        return 1;
    })->name('finances.delete');
});