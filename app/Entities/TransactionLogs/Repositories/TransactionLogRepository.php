<?php

namespace App\Entities\TransactionLogs\Repositories;

use App\Entities\TransactionLogs\Repositories\Interfaces\TransactionLogRepositoryInterface;
use App\Entities\TransactionLogs\TransactionLog;
use Illuminate\Support\Collection;

/**
 * Class TransactionLogRepository
 * 
 * @author Alexander Pedrozo Solano
 */
class TransactionLogRepository implements TransactionLogRepositoryInterface
{
    /**
     * @var TransactionLog
     */
    protected $transactionLog;

    /**
     * TransactionLogRepository constructor.
     * 
     * @param TransactionLog $transactionLog
     */
    public function __construct(TransactionLog $transactionLog)
    {
        $this->transactionLog = $transactionLog;
    }

    /**
     * @param array $columns
     * 
     * @return Collection
     */
    public function listTransactionLogs(array $columns = ['*']): Collection
    {
        return $this->transactionLog->get($columns);
    }

    /**
     * @param array $data
     * 
     * @return TransactionLog
     */
    public function createTransactionLog(array $data): TransactionLog
    {
        return $this->transactionLog->create($data);
    }

    /**
     * @param string $date
     * @param array $columns
     * 
     * @return array
     */
    public function getTransactionLogsByDate(string $date, array $columns = ['*']): array
    {
        return $this->transactionLog->where('created_at', '<=', $date)->get($columns)->toArray();
    }
}
