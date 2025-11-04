<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ResourceController;
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
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Mood Check-in
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');
    
    // Journal
    Route::resource('journal', JournalController::class);
    
    // Anonymous Chat
    Route::get('/chat/anonymous', [ChatController::class, 'anonymous'])->name('chat.anonymous');
    
    // Resources
    Route::resource('resources', ResourceController::class)->only(['index', 'show']);
});

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});