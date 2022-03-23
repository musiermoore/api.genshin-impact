<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user'])->middleware('auth:sanctum');;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/accounts', \App\Http\Controllers\AccountController::class);
    Route::post('/accounts/{id}/restore', [\App\Http\Controllers\AccountController::class, 'restore']);

    Route::prefix('/admin')->group(function () {
        Route::resource('/characters', \App\Http\Controllers\Admin\CharacterController::class)
            ->except('edit');
    });
});

