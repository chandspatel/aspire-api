<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoansController;

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
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/create-loan', [LoansController::class,'createLoan']);
    Route::get('/loans', [LoansController::class,'getLoans']);

    Route::post('/approve-loans', [LoansController::class,'approveLoans']);

    Route::post('/repayment-loans-amount', [LoansController::class,'repaymentLoansAmount']);


    Route::post('/logout', [AuthController::class,'logout']);
});
