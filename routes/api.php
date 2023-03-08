<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\LoanController;

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

Route::post('authentication',[AuthController::class,'userLogin']);
//Route::get('V1/group-summary',[HomeController::class,'groupSummary']);

Route::group(['middleware'=>'auth:api','prefix'=>'V1'],function(){
    Route::post('homepage',[HomeController::class,'index']);
    Route::post('group-summary',[HomeController::class,'groupSummary']);
    Route::post('all-member-payments',[PaymentController::class,'allPayments']);
    Route::post('member-payments',[PaymentController::class,'index']);
    Route::post('member-loans',[LoanController::class,'loanContracts']);
    Route::post('all-member-loans',[LoanController::class,'AllLoanContracts']);
});
