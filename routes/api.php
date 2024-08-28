<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MonsterController;
use App\Http\Controllers\Api\BattleController;
use App\Http\Controllers\Api\PythonController;

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

Route::controller(MonsterController::class)->prefix('monsters')->group(function () {
    Route::post('', 'store');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'remove');
    Route::post('import-csv', 'importCsv');
    Route::get('', 'index');
});

Route::controller(BattleController::class)->prefix('battles')->group(function () {
    Route::get('', 'index');
    Route::post('start', 'start');
});

Route::controller(PythonController::class)->prefix('python')->group(function () {
    Route::post('bg-remove', 'processBgRemove');
});
