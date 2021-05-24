<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CashRegisters\CashRegisterController;
use App\Http\Controllers\Api\Payments\PaymentController;
use App\Http\Controllers\Api\TransactionLogs\TransactionLogController;
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

Route::group(['prefix' => 'auth'], function () {

    Route::post('signup', [AuthController::class, 'signUp'])->name('signup');
    
    Route::post('login', [AuthController::class, 'login'])->name('login');  
      
});



Route::group(['prefix' => 'merqueoCash', 'middleware' => ['auth:api']], function () {
    Route::namespace('Api')->group(function () {
        Route::group(['prefix' => 'cashRegister'], function () {
            Route::namespace('CashRegisters')->group(function () {

                Route::post('/create', [CashRegisterController::class, 'createMoneyBaseCashRegister'])
                    ->name('cashRegister.create');

                Route::get('/withdrawAllMoney', [CashRegisterController::class, 'withdrawAllMoneyCashRegister'])
                    ->name('cashRegister.withdrawAllMoney');

                Route::get('/checkStatus', [CashRegisterController::class, 'checkStatusCashRegister'])
                    ->name('cashRegister.checkStatus');
                
            });
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::namespace('Payments')->group(function () {

                Route::post('/createPayment', [PaymentController::class, 'createPayment'])
                    ->name('payment.createPayment');

            });
            
        });

        Route::group(['prefix' => 'transactionLog'], function () {
            Route::namespace('TransactionLogs')->group(function () {

                Route::get('/getLogs', [TransactionLogController::class, 'getLogs'])
                    ->name('transactionLog.getLogs');
                
                Route::get('/getStatusByDate/{date}', [TransactionLogController::class, 'getStatusByDate'])
                    ->name('transactionLog.getStatusByDate');
            });
        });

    });    
});