<?php

namespace App\Entities\TransactionLogs\UseCases\Interfaces;

/**
 * Class TransactionLogUseCaseInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface TransactionLogUseCaseInterface
{
    /**
     * @return array
     */
    public function listTransactionLog():array;

    /**
     * @param string $date
     * 
     * @return array
     */
    public function getTransactionLogsByDate(string $date): array;
}
