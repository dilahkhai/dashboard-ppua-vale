<?php

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

Route::get('/data-dryerkiln', [App\Http\Controllers\dashboarddryerkilncontroller::class, 'get']);
Route::get('/data-furconv', [App\Http\Controllers\dashboardfurconvcontroller::class, 'get']);
Route::get('/data-infra', [App\Http\Controllers\dashboardinfracontroller::class, 'get']);
Route::get('/data-util', [App\Http\Controllers\dashboardutlcontroller::class, 'get']);
Route::get('/data-main', [App\Http\Controllers\TaskController::class, 'get']);
