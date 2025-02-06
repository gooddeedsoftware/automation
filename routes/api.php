<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CreditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Credit Management Routes
    Route::prefix('credits')->group(function () {
        Route::get('/', [CreditController::class, 'getCredits']);
        Route::post('/deduct', [CreditController::class, 'deductCredits']);
        Route::post('/add', [CreditController::class, 'addCredits']);
    });
});
