<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DevCI - Routes Web
|--------------------------------------------------------------------------
*/

// ── Page d'accueil ──────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Authentification ────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Développeurs (public) ───────────────────────────────────────────────
Route::get('/developers', [DeveloperController::class, 'index'])->name('developers.index');
Route::get('/developers/{id}', [DeveloperController::class, 'show'])->name('developers.show');
Route::post('/developers/{id}/contact', [DeveloperController::class, 'contact'])
    ->name('developers.contact')
    ->middleware('auth');

// ── Zone protégée ───────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');

    // Services (développeurs seulement)
    Route::middleware('role:developer')->group(function () {
        Route::get('/services', [ProfileController::class, 'services'])->name('services.index');
        Route::post('/services', [ProfileController::class, 'storeService'])->name('services.store');
        Route::put('/services/{id}', [ProfileController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{id}', [ProfileController::class, 'destroyService'])->name('services.destroy');
    });

    // Messagerie / Chat
    Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{conversationId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/messages/{conversationId}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/messages/{conversationId}/poll', [ChatController::class, 'poll'])->name('chat.poll');

    // Paiement
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/initiate', [PaymentController::class, 'initiate'])->name('payments.initiate');
    Route::get('/payments/callback/wave', [PaymentController::class, 'waveCallback'])->name('payments.wave.callback');
    Route::get('/payments/callback/orange', [PaymentController::class, 'orangeCallback'])->name('payments.orange.callback');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
});
