<?php

namespace App\Entities\Payments\UseCases\Interfaces;

/**
 * Class PaymentUseCaseInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface PaymentUseCaseInterface
{
    /**
     * @param array $data
     * 
     * @return array
     */
    public function createPayment(array $data): array;
}
