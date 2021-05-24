<?php

namespace App\Entities\TransactionLogs\Repositories\Interfaces;

use App\Entities\TransactionLogs\TransactionLog;
use Illuminate\Support\Collection;

/**
 * Class TransactionLogRepositoryInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface TransactionLogRepositoryInterface
{
    /**
     * @param array $columns
     * 
     * @return Collection
     */
    public function listTransactionLogs(array $columns = ['*']): Collection;

    /**
     * @param array $data
     * 
     * @return TransactionLog
     */
    public function createTransactionLog(array $data): TransactionLog;

    /**
     * @param string $date
     * @param array $columns
     * 
     * @return array
     */
    public function getTransactionLogsByDate(string $date, array $columns = ['*']): array;


}
