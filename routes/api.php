<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Dashboard\{ArticleController, ArticleImageController};
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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('article', ArticleController::class);
    Route::apiResource('article-detail', ArticleImageController::class);
});
