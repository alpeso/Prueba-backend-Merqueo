<?php

namespace App\Entities\CashRegisters\UseCases;

use App\Entities\CashRegisters\UseCases\Interfaces\CashRegisterUseCaseInterface;
use App\Entities\CashRegisters\Repositories\Interfaces\CashRegisterRepositoryInterface;
use App\Entities\TransactionLogs\Repositories\Interfaces\TransactionLogRepositoryInterface;

/**
 * Class CashRegisterUseCase
 * 
 * @author Alexander Pedrozo Solano
 */
class CashRegisterUseCase implements CashRegisterUseCaseInterface
{
    
    /**
     * @var CashRegisterRepositoryInterface
     */
    protected $cashRegisterInterface;

    /**
     * @var TransactionLogRepositoryInterface
     */
    protected $transactionLogInterface;
    
    /**
     * CashRegisterUseCase constructor.
     * 
     * @param CashRegisterRepositoryInterface $cashRegisterRepositoryInterface
     * @param TransactionLogRepositoryInterface $transactionLogRepositoryInterface
     */
    public function __construct(
        CashRegisterRepositoryInterface $cashRegisterRepositoryInterface,
        TransactionLogRepositoryInterface $transactionLogRepositoryInterface
    )
    {
        $this->cashRegisterInterface = $cashRegisterRepositoryInterface;
        $this->transactionLogInterface = $transactionLogRepositoryInterface;
    }

    /**
     * @param array $dataArray
     * 
     * @return array
     */
    public function createMoneyBase(array $dataArray): array
    {
        try {
            $cashRegister = $this->cashRegisterInterface->createOrUpdateCashRegister($dataArray);

            $transactionLog = $this->transactionLogInterface->createTransactionLog(
                [
                    'type' => 'load_base', 
                    'value' => $dataArray['value']
                ]
            );

            $cashRegister->transactionLogs()->attach($transactionLog,
                [
                    'cash_register_quantity' => $dataArray['quantity'
                ],
                'user_id' => auth()->user() ? auth()->user()->id : 1]
            );

            return [
                'status' => true,
                'message' => 'successfully loaded base'
            ];

        } catch (\Exception $e) {

            return [
                'status' => false, 
                'message' => $e->getMessage()
            ];
            
        }
    }
    
    /**
     * @return array
     */
    public function withdrawAllMoney(): array
    {
        $response = $this->cashRegisterInterface->setEmptyCashRegister();

        return [
            'status' => ($response) ? true : false, 
            'message' => ($response) ? 'success' : 'error',
        ];
    }

    /**
     * @return array
     */
    public function checkStatus(): array
    {
        $listCashRegisters = $this->cashRegisterInterface->listCashRegisters(
            ['*'], 
            [
                'column' => 'quantity', 
                'operator' => '>', 
                'value' => 0
            ]
        );

        $dataArray = [
            'total_cash_register' => 0,
            'coin' => [],
            'total_coin' => 0,
            'bill' => [],
            'total_bill' => 0
        ];
        
        foreach ($listCashRegisters as $cashRegister) {
                $dataArray['total_cash_register'] += $cashRegister['value'] * $cashRegister['quantity'];
                $dataArray[$cashRegister['denomination']][] = ['value' => $cashRegister['value'], 'quantity' => $cashRegister['quantity']];
                $dataArray['total_'.$cashRegister['denomination']] += $cashRegister['value'] * $cashRegister['quantity'];
        }

        return [
            'status' => true, 
            'message' => $dataArray
        ];
    }
}
