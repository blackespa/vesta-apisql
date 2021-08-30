<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoftlandController;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/hello', [AuthController::class, 'hello']);

Route::post('/getLedgerBook',[SoftlandController::class, 'getLedgerBook'])->name('getLedgerBook')->middleware('auth:sanctum');
Route::post('/getCustomers',[SoftlandController::class, 'getCustomers'])->name('getCustomers')->middleware('auth:sanctum');
