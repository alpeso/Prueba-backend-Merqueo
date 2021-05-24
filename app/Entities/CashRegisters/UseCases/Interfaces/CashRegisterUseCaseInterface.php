<?php


namespace App\Entities\CashRegisters\UseCases\Interfaces;

/**
 * Class CashRegisterUseCaseInterface
 * 
 * @author Alexander Pedrozo Solano
 */
interface CashRegisterUseCaseInterface
{
    /**
     * @param array $dataArray
     * 
     * @return array
     */
    public function createMoneyBase(array $dataArray): array;

    /**
     * @return array
     */
    public function withdrawAllMoney(): array;

    /**
     * @return array
     */
    public function checkStatus(): array;
}
