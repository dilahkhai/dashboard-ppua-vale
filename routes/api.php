<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueGanttController;


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

Route::get('/data-dryerkiln', [App\Http\Controllers\dashboarddryerkilncontroller::class, 'get']);
Route::get('/data-furconv', [App\Http\Controllers\dashboardfurconvcontroller::class, 'get']);
Route::get('/data-infra', [App\Http\Controllers\dashboardinfracontroller::class, 'get']);
Route::get('/data-util', [App\Http\Controllers\dashboardutlcontroller::class, 'get']);

Route::get('/data-project', [GanttController::class, 'get']);
Route::get('/data-issues', [IssueGanttController::class, 'get']);
Route::resource('task', TaskController::class);
