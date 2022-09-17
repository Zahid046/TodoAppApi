<?php

use App\Http\Controllers\AchievementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;


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

Route::group(['prefix' => 'todo'], function () {
    Route::get('index', [TodoController::class, 'index']);
    Route::post('show', [TodoController::class, 'show']);
    Route::get('total-completed', [TodoController::class, 'totalCompleted']);
    Route::get('total-incomplete', [TodoController::class, 'totalIncomplete']);
    Route::post('create', [TodoController::class, 'create']);
    Route::post('update', [TodoController::class, 'update']);
    Route::post('delete', [TodoController::class, 'delete']);
    Route::post('complete', [TodoController::class, 'toggle']);
});

Route::group(['prefix' => 'achievement'], function () {
    Route::get('index', [AchievementController::class, 'index']);
    Route::post('create', [AchievementController::class, 'create']);
    Route::post('update', [AchievementController::class, 'update']);
    Route::post('delete', [AchievementController::class, 'delete']);
});
