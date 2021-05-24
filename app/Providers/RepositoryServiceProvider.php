<?php

namespace App\Providers;

use App\Entities\CashRegisters\Repositories\CashRegisterRepository;
use App\Entities\CashRegisters\Repositories\Interfaces\CashRegisterRepositoryInterface;
use App\Entities\Payments\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Entities\Payments\Repositories\PaymentRepository;
use App\Entities\TransactionLogs\Repositories\TransactionLogRepository;
use App\Entities\TransactionLogs\Repositories\Interfaces\TransactionLogRepositoryInterface;
use App\Entities\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Entities\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );

        $this->app->bind(
            CashRegisterRepositoryInterface::class,
            CashRegisterRepository::class
        );

        $this->app->bind(
            TransactionLogRepositoryInterface::class,
            TransactionLogRepository::class
        );
    }

}
