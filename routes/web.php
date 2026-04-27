<?php

use App\Http\Controllers\DepartementController;

use App\Http\Controllers\AffectationController;

use App\Http\Controllers\LeadController;
use App\Http\Controllers\TacheController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ReunionController;
use Illuminate\Support\Facades\Route;

/*
FEATURES :  AUTHENTIFICATION
*/
// PAGE LOGIN
Route::get('/', function () {
    return view('login');
});
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/auth/me', [UserController::class, 'me'])->name('profile');

/*
FEATURES :  TRANSACTIONS FINANCIÈRES
*/
Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/show/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::post('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/delete/{id}', [TransactionController::class, 'destroy'])->name('Transactions.destroy');
});

/*
FEATURES :  TÂCHES
*/
Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/all', [TaskController::class, 'all'])->name('tasks.all');
    Route::get('/overdue', [TaskController::class, 'overdue'])->name('tasks.overdue');
    Route::get('/completed', [TaskController::class, 'completed'])->name('tasks.completed');
    Route::get('/pending', [TaskController::class, 'pending'])->name('tasks.pending');
    Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/update/status/{id}', [TaskController::class, 'status'])->name('tasks.status');
    Route::patch('/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

/*
FEATURES :  EMPLOYÉS (RH)
*/
Route::prefix('employes')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employes.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employes.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employes.store');
    Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('employes.show');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employes.edit');
    Route::get('/{id}/assign', [EmployeeController::class, 'assign'])->name('employes.assign');
    Route::get('/{id}/status', [EmployeeController::class, 'status'])->name('employes.status');
    Route::patch('/update/{id}', [EmployeeController::class, 'update'])->name('employes.update');
    Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->name('employes.destroy');
});

/*
FEATURES : CANDIDATURES (Recrutement)
*/
Route::prefix('recrutement')->group(function () {
    Route::get('/', [RecrutementController::class, 'index'])->name('recrutement.index');
    Route::get('/create', [RecrutementController::class, 'create'])->name('recrutement.create');
    Route::post('/store', [RecrutementController::class, 'store'])->name('recrutement.store');
    Route::get('/show/{id}', [RecrutementController::class, 'show'])->name('recrutement.show');
    Route::get('/edit/{id}', [RecrutementController::class, 'edit'])->name('recrutement.edit');
    Route::get('/{id}/status', [RecrutementController::class, 'status'])->name('recrutement.status');
    Route::patch('/update/{id}', [RecrutementController::class, 'update'])->name('recrutement.update');
    Route::delete('/delete/{id}', [RecrutementController::class, 'destroy'])->name('recrutement.destroy');
    Route::get('/{id}/candidatures', [RecrutementController::class, 'candidatures'])->name('recrutement.candidatures');
    Route::post('/{id}/candidatures/store', [RecrutementController::class, 'candidatures_store'])->name('recrutement.candidatures.store');
});

Route::prefix('candidatures')->group(function () {
    Route::get('/{id}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::get('/edit/{id}', [CandidatureController::class, 'edit'])->name('candidatures.edit');
    Route::put('/{id}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::patch('/{id}/status', [CandidatureController::class, 'status'])->name('candidatures.status');
    Route::delete('/delete/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
});
/*
END FEATURES : CANDIDATURES (Recrutement)
*/

/*
FEATURES : BLOC NOTES
*/
Route::prefix('notes')->group(function () {
    Route::get('/', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/store', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/show/{id}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/edit/{id}', [NoteController::class, 'edit'])->name('notes.edit');
    Route::patch('/update/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/delete/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

/*
FEATURES : DEPARTEMENT
*/
Route::prefix('departements')->group(function () {
    Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
    Route::get('/create', [DepartementController::class, 'create'])->name('departements.create');
    Route::post('/store', [DepartementController::class, 'store'])->name('departements.store');
    Route::get('/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
    Route::post('/update/{id}', [DepartementController::class, 'update'])->name('departements.update');
    Route::delete('/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');
    Route::get('/show/{id}', [DepartementController::class, 'show'])->name('departements.show');
    Route::get('/{id}/recrutements', [DepartementController::class, 'show'])->name('departements.recrutements');
    Route::get('/{id}/employes', [DepartementController::class, 'show'])->name('departements.employes');
});

/*
FEATURES : Conversations
*/
Route::prefix('conversations')->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('conversations.index');
    Route::post('/store', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('/show/{id}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::get('/{id}/messages', [ConversationController::class, 'messages'])->name('conversations.messages');
    Route::get('/users/search?q=', [ConversationController::class, 'search'])->name('conversations.search');
    Route::get('/users/online', [ConversationController::class, 'online'])->name('conversations.online');
    Route::get('/users/status', [ConversationController::class, 'online_status'])->name('conversations.online_status');
    Route::get('/{id}/messages', [ConversationController::class, 'messages'])->name('conversations.messages');
});

Route::prefix('mesages')->group(function () {
    Route::post('/store', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/{id}/read', [MessageController::class, 'read'])->name('messages.read');
    Route::delete('/delete/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});


/*
FEATURES : Reunions
*/
Route::prefix('reunions')->group(function () {
    Route::get('/', [ReunionController::class, 'index'])->name('reunion.index');
    Route::get('/upcoming', [ReunionController::class, 'upcoming'])->name('reunion.upcoming');
    Route::get('/past', [ReunionController::class, 'past'])->name('reunion.past');
    Route::get('/show/{id}', [ReunionController::class, 'show'])->name('reunion.show');
    Route::post('/store', [ReunionController::class, 'store'])->name('reunion.store');
    Route::get('/edit/{id}', [ReunionController::class, 'edit'])->name('reunion.edit');
    Route::put('/update/{id}', [ReunionController::class, 'update'])->name('reunion.update');
    Route::patch('/{id}/status', [ReunionController::class, 'status'])->name('reunion.status');
    Route::post('/{id}/invite', [ReunionController::class, 'invite'])->name('reunion.invite');
    Route::get('/delete/{id}', [ReunionController::class, 'delete'])->name('reunion.delete');
});

/*
FEATURES : Leads
*/
Route::prefix('lead')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('lead.index');
    Route::post('/store', [LeadController::class, 'store'])->name('lead.store');
    Route::put('/update/{id}', [LeadController::class, 'update'])->name('lead.update');
    Route::patch('/{id}/status', [LeadController::class, 'status'])->name('lead.status');
    Route::get('/delete/{id}', [LeadController::class, 'delete'])->name('lead.delete');
});

//Page utilisateur
Route::get('/users', function () {
    return view('auth.utilisateurs.users');
})->name('users');

//affichage des utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/creatusers', [UserController::class, 'creatusers'])->name('users.creatusers');

//register
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');

Route::get('/users/attribuer/{id}', [UserController::class, 'attribuer'])->name('users.attribuer');

//affectations
Route::post('/affectations', [AffectationController::class, 'store'])->name('affectations.store');

Route::get('/affectation/{id}', [AffectationController::class, 'create'])->name('affectations.create');


//Page Dashboard



// DASHBOARD
Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->name('dashboard');

// DEPARTEMENTS
// Route::prefix('departements')->group(function () {
//     Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
//     Route::get('/create', [DepartementController::class, 'create'])->name('departements.create');
//     Route::post('/store', [DepartementController::class, 'store'])->name('departements.store');
//     Route::get('/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
//     Route::post('/update/{id}', [DepartementController::class, 'update'])->name('departements.update');
//     Route::delete('/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');
//     Route::get('/show/{id}', [DepartementController::class, 'show'])->name('departements.show');
// });

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