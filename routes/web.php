<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Loan\LoanApplicationController;
use App\Http\Controllers\Loan\LoanController;
use App\Http\Controllers\Payment\PaymentController;

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

Route::get('/',[LoginController::class,'index'])->name('/');
Route::post('user/authentication',[LoginController::class,'authentication'])->name('authenticate.user');

Route::group(['middleware'=>"auth"],function(){
    Route::get('change-password',[LoginController::class,'changePasswordForm'])->name('change.password');
    Route::post('change-password-request',[LoginController::class,'changePassword'])->name('change.password.request');
    Route::get('dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::get('colum-chart',[AdminController::class,'columnChart'])->name('column.chart');
    Route::get('logout',[LoginController::class,'logout'])->name('logout');
    Route::post('update-member',[MemberController::class,'updateMember'])->name('update.member');
    Route::post('payment-request',[PaymentController::class,'paymentRequest'])->name('payment.request');
    Route::get('payment-disbursed',[PaymentController::class,'paymentDisbursed'])->name('payment.disbursed');
    Route::get('pending-payments',[PaymentController::class,'pendingPayments'])->name('pending.payments');
    Route::post('approve-payment',[PaymentController::class,'approvePayment'])->name('approve.payment');

    Route::resources([
        'users'          =>UserController::class,
        'members'        =>MemberController::class,
        'applications'   =>LoanApplicationController::class,
        'loan'           =>LoanController::class,
        'payment'        =>PaymentController::class,
        'roles'          =>RoleController::class,
        'permissions'    =>PermissionController::class,
       ]);
});
