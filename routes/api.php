<?php

use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\TemperatureController;
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

Route::middleware('auth:sanctum')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/rooms', [RoomsController::class, 'listRooms']);
        Route::get('/rooms/{room}', [RoomsController::class, 'getRoom']);
        Route::post('/rooms/{room}', [RoomsController::class, 'saveRoom']);
        Route::post('/rooms', [RoomsController::class, 'createRoom']);

        Route::post('/rooms/{room}/record', [TemperatureController::class, 'addReading']);
    }
);
