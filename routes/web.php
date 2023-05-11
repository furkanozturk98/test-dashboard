<?php

use App\Http\Controllers\Api\TestRunDetailController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
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

Route::namespace('App\Http\Controllers')->group(function() {
    Auth::routes([
        'register' => false,
        'reset'    => false,
        'confirm'  => false,
        'verify'   => false,
    ]);
});

Route::middleware('auth')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/details/{testRun}', [DashboardController::class, 'details'])->name('details');
    Route::get('/list', [DashboardController::class, 'list'])->name('list');

    Route::prefix('api')->group(function() {
        Route::get('test-run-details/{testRun}', [TestRunDetailController::class, 'index']);
    });
});
