<?php

use App\Http\Controllers\DepartementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// PAGE LOGIN
Route::get('/', function () {
return view('login');
});


// Traitement login
Route::post('login', [UserController::class, 'login'])->name('login');

// Logout
Route::post('logout', [UserController::class, 'logout'])->name('logout');

<<<<<<< HEAD
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
=======

// DASHBOARD
>>>>>>> 783f9d8731a60689c938e51003d64c02926fd9a1
Route::get('/dashboard', function () {
return view('auth.dashboard');
})->name('dashboard');

// DEPARTEMENTS
Route::prefix('departements')->group(function () {
Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
Route::get('/create', [DepartementController::class, 'create'])->name('!!!!');
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