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

Route::group(['middleware'=>'auth:api','prefix'=>'V1'],function(){
    Route::post('homepage',[HomeController::class,'index']);
    Route::post('member-payments',[PaymentController::class,'index']);
    Route::post('member-loans',[LoanController::class,'loanContracts']);
});
