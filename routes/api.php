<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EnregistrementController;
use App\Http\Controllers\Api\ListeningController;
use App\Http\Controllers\Api\VisitController;
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

        // Enregistrement d'une lecture
        Route::post('listen', ListeningController::class);

        // Enregistrement d'une visite
        Route::post('visit', VisitController::class);
    });
