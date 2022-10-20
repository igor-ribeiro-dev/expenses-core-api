<?php

use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\BudgetsExpensesController;
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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('budgets', BudgetsController::class);
    Route::apiResource('budgets.expenses', BudgetsExpensesController::class);
});
