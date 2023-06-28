<?php

use App\Http\Api\EnregistrementController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(EnregistrementController::class)
    ->prefix('audio')
    ->as('audio.')
    ->group(function () {
        // Route pour générer le fichier audio
        Route::post('/', 'store')->name('store');

        // Route pour récupérer le fichier audio
        Route::get('/{audio:uuid}', 'show')->name('show');
    });
