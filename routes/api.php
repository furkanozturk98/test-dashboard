<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TestRunController;
use App\Http\Controllers\Api\TestRunDetailController;
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

Route::middleware('auth:api')->group(function() {
    Route::apiResource('test-runs', TestRunController::class);

    Route::get('test-duration-count/{testRun}', [TestRunDetailController::class, 'getTestCountsByDuration']);
    Route::get('dashboard/history', [DashBoardController::class, 'history']);
    Route::get('test-run-statuses', [TestRunController::class, 'getStatuses']);
});
