<?php

namespace App\Providers;

use App\Entities\CashRegisters\UseCases\CashRegisterUseCase;
use App\Entities\CashRegisters\UseCases\Interfaces\CashRegisterUseCaseInterface;
use App\Entities\Payments\UseCases\Interfaces\PaymentUseCaseInterface;
use App\Entities\Payments\UseCases\PaymentUseCase;
use App\Entities\TransactionLogs\UseCases\Interfaces\TransactionLogUseCaseInterface;
use App\Entities\TransactionLogs\UseCases\TransactionLogUseCase;
use App\Entities\Users\UseCases\Interfaces\UserUseCaseInterface;
use App\Entities\Users\UseCases\UserUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserUseCaseInterface::class,
            UserUseCase::class
        );

        $this->app->bind(
            CashRegisterUseCaseInterface::class,
            CashRegisterUseCase::class
        );

        $this->app->bind(
            TransactionLogUseCaseInterface::class,
            TransactionLogUseCase::class
        );

        $this->app->bind(
            PaymentUseCaseInterface::class,
            PaymentUseCase::class
        );
    }
}
