<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingProvidersConfigController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\BudgetsExpensesController;
use App\Http\Controllers\ExpensesController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('budgets', BudgetsController::class);
    Route::apiResource('budgets.expenses', BudgetsExpensesController::class);
    Route::apiResource('expenses', ExpensesController::class)->only('index');
    Route::post('expenses/{id}/toggle-paid', [ExpensesController::class, 'togglePaid']);
    Route::apiResource('billing-provider/config', BillingProvidersConfigController::class);
});
