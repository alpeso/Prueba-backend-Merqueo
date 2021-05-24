<?php

namespace App\Http\Controllers\Api\TransactionLogs;

use App\Entities\TransactionLogs\UseCases\Interfaces\TransactionLogUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class TransactionLogController
 * 
 * @author Alexander Pedrozo Solano
 */
class TransactionLogController extends Controller
{
    /**
     * @var TransactionLogUseCaseInterface
     */
    protected $transactionLogInterface;

    /**
     * @param TransactionLogUseCaseInterface $transactionLogUseCaseInterface
     */
    public function __construct(TransactionLogUseCaseInterface $transactionLogUseCaseInterface)
    {
        $this->transactionLogInterface = $transactionLogUseCaseInterface;
    }

    /**
     * @return JsonResponse
     */
    public function getLogs(): JsonResponse
    {
        $response = $this->transactionLogInterface->listTransactionLog();

        return response()->json($response, ($response['status']) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param mixed $date
     * 
     * @return JsonResponse
     */
    public function getStatusByDate($date): JsonResponse
    {
        $response = $this->transactionLogInterface->getTransactionLogsByDate($date);

        return response()->json($response, ($response['status']) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
