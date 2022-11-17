<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MotivasiController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/registrasi', [RegistrasiController::class, 'registrasi']);
Route::post('/login', [LoginController::class, 'login']);

Route::prefix('user/{id}')->group(function () {
    Route::get('/', [UserController::class, 'profil']);
    Route::put('/ubah-password', [UserController::class, 'ubahPassword']);
});

Route::prefix('user/{userId}/motivasi')->group(function () {
    Route::get('/', [MotivasiController::class, 'getAll']);
    Route::post('/', [MotivasiController::class, 'create']);
    Route::put('/{id}', [MotivasiController::class, 'update']);
    Route::delete('/{id}', [MotivasiController::class, 'delete']);
});
