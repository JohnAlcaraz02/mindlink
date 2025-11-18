<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Guest routes (not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Mood tracking routes
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');
    
    // Journal routes
    Route::prefix('journal')->name('journal.')->group(function() {
        Route::get('/', [JournalController::class, 'index'])->name('index');
        Route::post('/store', [JournalController::class, 'store'])->name('store');
        Route::get('/{id}', [JournalController::class, 'show'])->name('show');
        Route::put('/{id}', [JournalController::class, 'update'])->name('update');
        Route::delete('/{id}', [JournalController::class, 'destroy'])->name('destroy');
    });
    
    // Chat routes
    Route::prefix('chat')->name('chat.')->group(function() {
        // Directly send users to anonymous chat (remove picker)
        Route::get('/', function() {
            return redirect()->route('chat.anonymous');
        })->name('index');
        Route::get('/anonymous', [ChatController::class, 'anonymous'])->name('anonymous');
        Route::post('/send', [ChatController::class, 'sendMessage'])->name('send');
        // AI chat
        Route::get('/ai', [ChatController::class, 'ai'])->name('ai');
        Route::post('/ai/send', [ChatController::class, 'sendAi'])->name('ai.send');
    });
    
    // Resources routes (placeholder)
    Route::get('/resources', function() {
        return view('resources.index');
    })->name('resources.index');

    // Profile routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});