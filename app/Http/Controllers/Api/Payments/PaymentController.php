<?php

namespace App\Http\Controllers\Api\Payments;

use App\Entities\CashRegisters\Requests\CreatePaymentRequest;
use App\Entities\Payments\UseCases\Interfaces\PaymentUseCaseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class PaymentController
 * 
 * @author Alexander Pedrozo Solano
 */
class PaymentController extends Controller
{
    /**
     * @var PaymentUseCaseInterface
     */
    protected $paymentInterface;

    /**
     * @param PaymentUseCaseInterface $paymentUseCaseInterface
     */
    public function __construct(PaymentUseCaseInterface $paymentUseCaseInterface)
    {
        $this->paymentInterface = $paymentUseCaseInterface;
    }

    /**
     * @param CreatePaymentRequest $createPaymentRequest
     * 
     * @return JsonResponse
     */
    public function createPayment(CreatePaymentRequest $createPaymentRequest): JsonResponse
    {
        $response = $this->paymentInterface->createPayment($createPaymentRequest->input());

        return response()->json($response, ($response['status']) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
