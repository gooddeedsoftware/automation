<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserCreditController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['web', 'auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/test', function() {
            dd('Admin middleware is working!');
        });

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // User Management Routes
        Route::resource('users', UserController::class);
        
        // Subscription Management Routes
        Route::resource('subscriptions', SubscriptionController::class);

        // Credit management routes
        Route::get('/users/{user}/credits', [UserCreditController::class, 'index'])
            ->name('users.credits.index');
        Route::post('/users/{user}/credits/add', [UserCreditController::class, 'addCredits'])
            ->name('users.credits.add');
        Route::post('/users/{user}/credits/deduct', [UserCreditController::class, 'deductCredits'])
            ->name('users.credits.deduct');
    });
