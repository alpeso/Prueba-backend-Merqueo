<?php

namespace App\Entities\Payments\UseCases;

use App\Entities\CashRegisters\Repositories\Interfaces\CashRegisterRepositoryInterface;
use App\Entities\Payments\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Entities\Payments\UseCases\Interfaces\PaymentUseCaseInterface;
use App\Entities\TransactionLogs\Repositories\Interfaces\TransactionLogRepositoryInterface;

/**
 * Class PaymentUseCase
 * 
 * @author Alexander Pedrozo Solano
 */
class PaymentUseCase implements PaymentUseCaseInterface
{
    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentInterface;

    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterInterface;

    /**
     * @var TransactionLogRepositoryInterface
     */
    protected $transactionLogInterface;

    /**
     * PaymentUseCase constructor.
     * 
     * @param PaymentRepositoryInterface $paymentRepositoryInterface
     * @param CashRegisterRepositoryInterface $cashRegisterRepositoryInterface
     * @param TransactionLogRepositoryInterface $transactionLogRepositoryInterface
     */
    public function __construct(
        PaymentRepositoryInterface $paymentRepositoryInterface,
        CashRegisterRepositoryInterface $cashRegisterRepositoryInterface,
        TransactionLogRepositoryInterface $transactionLogRepositoryInterface
    ){
        $this->paymentInterface = $paymentRepositoryInterface;
        $this->cashRegisterInterface = $cashRegisterRepositoryInterface;
        $this->transactionLogInterface = $transactionLogRepositoryInterface;
    }

    /**
     * @param array $data
     * 
     * @return array
     */
    public function createPayment(array $data): array
    {
        try {

            $checkCashReturn = $this->totalReturned($data['customer_payment'], $data['amount_payable']);

            if (empty($checkCashReturn)) return ['status' => false, 'message' => 'There is not enough money to pay back'];

            $data['total_returned'] = $checkCashReturn['total_returned'];

            $this->paymentInterface->createPayment($data);

            $dataCreate = [
                'denomination' => $data['payment_denomination'],
                'value'        => $data['customer_payment'],
                'quantity'     => 1
            ];

            $this->createCashRegisterAndLog($dataCreate, 'payment', 'sum');

            foreach ($checkCashReturn['data'] as $key => $value){
                $this->createCashRegisterAndLog($value, 'cash_back', 'rest');
            }

            $checkCashReturn['data'] = array_values($checkCashReturn['data']);

            return [
                'status' => true, 
                'message' => $checkCashReturn
            ];
            
        } catch (\Exception $e) {

            return [
                'status' => false, 
                'message' => $e->getMessage()
            ];

        }
    }

    /**
     * @param array $data
     * @param string $type
     * @param string $operator
     * 
     * @return void
     */
    private function createCashRegisterAndLog(array $data, string $type, string $operator): void
    {
        $cashRegister = $this->cashRegisterInterface->createOrUpdateCashRegister([
            'denomination' => $data['denomination'],
            'value'        => $data['value'],
            'quantity'     => $data['quantity']
        ],$operator);

        $log = $this->transactionLogInterface->createTransactionLog(
            [
                'type'  => $type,
                'value' => $data['value']
            ]
        );

        $cashRegister->transactionLogs()->attach($log,
            [
                'cash_register_quantity' => $data['quantity'],
                'user_id' =>  auth()->user() ? auth()->user()->id : 1
            ]
        );
    }

    /**
     * @param int $pay
     * @param int $amount
     * 
     * @return array
     */
    private function totalReturned(int $pay, int $amount): array
    {
        $cashRegisters = $this->cashRegisterInterface->listCashRegisters(
            ['denomination', 'value', 'quantity'],
            [
                'column' => 'quantity', 
                'operator' => '>', 
                'value' => 0
            ]
        );

        if (empty($cashRegisters)) return [];
        
        $moneyReturn = $pay - $amount;

        $data = [
            'total_returned' => $moneyReturn,
            'data'           => []
        ];

        $remaining = $moneyReturn;

        foreach ($cashRegisters as $cashRegister) {

            for ($i = 1; $i <= $cashRegister['quantity']; $i++) {
                
                if($remaining >= $cashRegister['value']){

                    $quantity = 1;

                    $remaining = $remaining - $cashRegister['value'];

                    if (isset($data['data'][$cashRegister['value']])) $quantity = $data['data'][$cashRegister['value']]['quantity'] + 1;                        

                    $data['data'][$cashRegister['value']] = [
                        'denomination' => $cashRegister['denomination'],
                        'value' => $cashRegister['value'],
                        'quantity' => $quantity
                    ];                   

                }

                if($remaining == 0) break;
            }

        }

        if($remaining > 0) return [];

        return $data;
    }
}
