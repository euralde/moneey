<?php

use App\Http\Controllers\DepartementController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

// PAGE LOGIN
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
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');

Route::post('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');


 
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

// TACHES
Route::prefix('taches')->group(function () {
    Route::get('/', [TacheController::class, 'index'])->name('taches.index');
    Route::get('/create', [TacheController::class, 'create'])->name('taches.create');
    Route::post('/store', [TacheController::class, 'store'])->name('taches.store');
    Route::get('/edit/{id}', [TacheController::class, 'edit'])->name('taches.edit');
    Route::post('/update/{id}', [TacheController::class, 'update'])->name('taches.update');
    Route::delete('/delete/{id}', [TacheController::class, 'destroy'])->name('taches.destroy');
    Route::get('/show/{id}', [TacheController::class, 'show'])->name('taches.show');
});

// MESSAGES
Route::prefix('messages')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/store', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/edit/{id}', [MessageController::class, 'edit'])->name('messages.edit');
    Route::post('/update/{id}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/delete/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/show/{id}', [MessageController::class, 'show'])->name('messages.show');
});

// FINANCES
Route::prefix('finances')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('finances.index');
    Route::get('/create', [FinanceController::class, 'create'])->name('finances.create');
    Route::post('/store', [FinanceController::class, 'store'])->name('finances.store');
    Route::get('/show/{id}', [FinanceController::class, 'show'])->name('finances.show');
    Route::get('/edit/{id}', [FinanceController::class, 'edit'])->name('finances.edit');
    Route::post('/update/{id}', [FinanceController::class, 'update'])->name('finances.update');
    Route::delete('/delete/{id}', [FinanceController::class, 'destroy'])->name('finances.destroy');
});

// ROUTES AJAX POUR LE CHAT MESSAGES
Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
Route::get('/messages/conversation/{user}', [MessageController::class, 'getConversation'])->name('messages.conversation');
Route::get('/messages/users', [MessageController::class, 'getUsers'])->name('messages.users');