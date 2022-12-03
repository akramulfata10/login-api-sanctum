<?php

use Illuminate\Http\Request;
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
// Route::get('/view-user', [\App\Http\Controllers\Api\AuthController::class, 'tes']);
Route::post('/registrasi-user', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login-user', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// Route::resource('/categories', \App\Http\Controllers\Api\CategoryController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::resource('/posts', \App\Http\Controllers\Api\PostController::class);
    Route::resource('/categories', \App\Http\Controllers\Api\CategoryController::class);
});