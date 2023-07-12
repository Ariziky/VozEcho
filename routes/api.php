<?php

use App\Http\Api\AuthController;
use App\Http\Api\EnregistrementController;
use App\Http\Api\ListeningController;
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

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:api'])
    ->get('user', function (Request $request) {
        return $request->user();
    });

//Route::controller(EnregistrementController::class)
//    ->middleware(['auth:sanctum', 'throttle:api'])
//    ->prefix('audio')
//    ->as('audio.')
//    ->group(function () {
//        // Route pour générer le fichier audio
//        Route::post('/', 'store')->name('store');
//
//        // Route pour récupérer le fichier audio
//        Route::get('/{audio:uuid}', 'show')->name('show');
//    });

Route::middleware(['auth:sanctum', 'throttle:api'])
    ->group(function () {
        Route::apiResource('audio', EnregistrementController::class)
            ->only(['store', 'show']);

        Route::post('listen', ListeningController::class);
    });
