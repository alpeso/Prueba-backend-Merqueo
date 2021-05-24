<?php

namespace App\Entities\Payments\Repositories\Interfaces;

use App\Entities\Payments\Payment;

/**
 * Class PaymentRepositoryInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface PaymentRepositoryInterface
{
    /**
     * @param array $data
     * 
     * @return Payment
     */
    public function createPayment(array $data): Payment;
}
