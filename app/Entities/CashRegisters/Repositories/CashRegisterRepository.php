<?php

namespace App\Entities\CashRegisters\Repositories;

use App\Entities\CashRegisters\CashRegister;
use App\Entities\CashRegisters\Repositories\Interfaces\CashRegisterRepositoryInterface;

/**
 * Class CashRegisterRepository
 * 
 * @author Alexander Pedrozo Solano
 */
class CashRegisterRepository implements CashRegisterRepositoryInterface
{
    /**
     * @var CashRegister
     */
    protected $cashRegister;
    
    /**
     * CashRegisterRepository constructor.
     * 
     * @param CashRegister $cashRegister
     */
    public function __construct(CashRegister $cashRegister)
    {
        $this->cashRegister = $cashRegister;
    }

    /**
     * @param array $columns
     * @param array $where
     * 
     * @return array
     */
    public function listCashRegisters(array $columns = ['*'], array $where = []): array
    {
        $cashRegisterList = $this->cashRegister
            ->when($where, function ($query, $where) {
                return $query->where($where['column'], $where['operator'], $where['value']);
            })
            ->orderBy('value', 'DESC')
            ->get($columns);

        return $cashRegisterList ? $cashRegisterList->toArray():[];
    }

    /**
     * @param array $data
     * 
     * @return CashRegister
     */
    public function createCashRegister(array $data): CashRegister
    {
        return $this->cashRegister->create($data);
    }

    /**
     * @param array $data
     * @param string $operation
     * 
     * @return CashRegister
     */
    public function createOrUpdateCashRegister(array $data, string $operation = 'sum'): CashRegister
    {
        $cashRegister = $this->cashRegister
            ->where('denomination', $data['denomination'])
            ->where('value', $data['value'])
            ->first();

        if (null !== $cashRegister) {
            if($operation === 'sum'){
                $quantity = $cashRegister->quantity + $data['quantity'];
            }else{
                $quantity = $cashRegister->quantity - $data['quantity'];
            }

            $cashRegister->update(['quantity' => $quantity]);
        }else{
            $cashRegister = $this->createCashRegister($data);
        }

        return $cashRegister;
    }

    /**
     * @return bool
     */
    public function setEmptyCashRegister(): bool
    {
        return $this->cashRegister->where('quantity', '>', 0)->update(['quantity' => 0]);
    }

}
