<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('cars', CarController::class);
});
