<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SensorsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('rooms', RoomsController::class)->scoped(['room' => 'slug']);
        Route::resource('sensors', SensorsController::class)->scoped(['sensor' => 'slug']);
    }
);

