<?php

namespace App\Http\Controllers\Api\CashRegisters;

use App\Entities\CashRegisters\UseCases\Interfaces\CashRegisterUseCaseInterface;
use App\Entities\Payments\Requests\CreateCashRegisterRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CashRegisterController
 * 
 * @author Alexander Pedrozo Solano
 */
class CashRegisterController extends Controller
{
    /**
     * @var CashRegisterUseCaseInterface
     */
    protected $cashRegisterInterface;

    /**
     * @param CashRegisterUseCaseInterface $cashRegisterUseCaseInterface
     */
    public function __construct(CashRegisterUseCaseInterface $cashRegisterUseCaseInterface )
    {
        $this->cashRegisterInterface = $cashRegisterUseCaseInterface;
    }

    /**
     * @param CreateCashRegisterRequest $createCashRegisterRequest
     * 
     * @return JsonResponse
     */
    public function createMoneyBaseCashRegister(CreateCashRegisterRequest $createCashRegisterRequest): JsonResponse
    {
        $response = $this->cashRegisterInterface->createMoneyBase($createCashRegisterRequest->input());

        return response()->json($response, ($response['status']) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @return JsonResponse
     */
    public function withdrawAllMoneyCashRegister(): JsonResponse
    {
        $response = $this->cashRegisterInterface->withdrawAllMoney();

        return response()->json($response, ($response['status']) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @return JsonResponse
     */
    public function checkStatusCashRegister(): JsonResponse
    {
        $response = $this->cashRegisterInterface->checkStatus();

        return response()->json($response, Response::HTTP_OK);
    }
}
