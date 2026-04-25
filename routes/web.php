<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Page login
Route::get('/', function () {
    return view('login');
});

// Traitement login
Route::post('login', [UserController::class, 'login'])->name('login');

// Logout
Route::post('logout', [UserController::class, 'logout'])->name('logout');

//Page utilisateur
Route::get('/users', function () {
    return view('auth.utilisateurs.users');
})->name('users');

//affichage des utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('users');

//register
Route::post('/register', [UserController::class,'store'])->name('register');

Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');

Route::post('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');

//Page Dashboard
Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->name('dashboard');

//Pages Departements
Route::prefix('departements')->group(function () {
    Route::get('/', function () {
        return view('auth.departments.show');
    })->name('departments.show');

    Route::get('/create', function () {
        return view('auth.departments.create');
    })->name('departments.create');

    Route::get('/details/{id}', function ($id) {
        return view('auth.departments.detail');
    })->name('departments.detail');

    Route::get('/update/{id}', function ($id) {
        return view('auth.departments.update');
    })->name('departments.update');

    Route::get('/delete/{id}', function ($id) {
        return 1;
    })->name('departments.delete');
});


//Pages Finances
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
