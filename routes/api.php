<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FavoriteCoinController;
use App\Http\Controllers\ReadJsonFileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/json', [ReadJsonFileController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::post('/create-transaction', [TransactionController::class, 'store']);
    Route::put('/update-transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('/delete-transaction/{id}', [TransactionController::class, 'destroy']);

    Route::get('/favorite-coins', [FavoriteCoinController::class, 'index']);
    Route::post('/favorite-coins', [FavoriteCoinController::class, 'store']);
    Route::delete('/favorite-coins/{id}', [FavoriteCoinController::class, 'destroy']);

    Route::get('/profile', [UserController::class, 'index']);
    Route::put('/update-profile', [UserController::class, 'updateProfile']);
    Route::get('/historicals', [UserController::class, 'getHistoricals']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});
