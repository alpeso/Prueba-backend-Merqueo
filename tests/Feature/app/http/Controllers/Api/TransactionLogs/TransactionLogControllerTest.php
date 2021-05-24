<?php

namespace Tests\Feature\app\Http\Controllers\Api\TransactionLogs;

use App\Entities\CashRegisters\CashRegister;
use App\Entities\TransactionLogs\TransactionLog;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TransactionLogControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    /**
     * @return TransactionLog
     */
    public function createtransactionLogs()
    {
        $user = User::factory()->create();

        $cashRegister = CashRegister::factory()->create();

        $transactionLogs = TransactionLog::factory(6)->create([
            'value' => $cashRegister->value
        ]);

        foreach ($transactionLogs as $log) {            
            $cashRegister->transactionLogs()->attach($log,
                [
                    'cash_register_quantity' => $cashRegister->quantity,
                    'user_id' => $user->id
                ]
            );
        }

        return $transactionLogs;
    }

    /**
     * @param mixed $transactionLogs
     * 
     * @return array
     */
    public function getTotalCashRegister($transactionLogs)
    {
        $totalCashRegister = 0;

        foreach ($transactionLogs as $transactionLog) {

            if ($transactionLog['type'] === 'cash_back')  $totalCashRegister -= $transactionLog['value'];    

            $totalCashRegister += $transactionLog['value'];
        }

        return [
            'totalCashRegister' => $totalCashRegister,
            'date' => isset($transactionLog->created_at)? $transactionLog->created_at: (new \DateTime())->format('Y-m-d H:i:s'),
        ];
    }

    public function test_list_transaction_log_success(): void
    {
        $this->createtransactionLogs();

        $request = $this->get(route('transactionLog.getLogs'), ['Accept' => 'application/json']);

        $request->assertStatus(200);
    }

    public function test_list_transaction_Log_empty(): void
    {
        $request = $this->get(route('transactionLog.getLogs'), ['Accept' => 'application/json']);

        $request->assertStatus(500)->assertJsonStructure([
            'status', 
            'message'
        ]);
    }

    public function test_list_transaction_log_error(): void
    {
        $request = $this->get(route('transactionLog.getLogs'), ['Accept' => 'application/json']);

        $request->assertStatus(500);
    }

    public function test_get_status_by_date_success(): void
    {
        $transactionLogs = $this->createtransactionLogs();
        
        $data = $this->getTotalCashRegister($transactionLogs);

        $totalCashRegister = $data['totalCashRegister'];

        $request = $this->get(route('transactionLog.getStatusByDate', $data['date']), ['Accept' => 'application/json']);

        $request->assertStatus(200)->assertJson([
            'status' => true,
            'message' => [
                'total_cash_register' => $totalCashRegister
            ]
        ]);
    }
    
    public function test_get_status_by_date_error(): void
    {
        $request = $this->get(route('transactionLog.getStatusByDate', '2021-05-25 17:24:09'),
            ['Accept' => 'application/json']);

        $request->assertStatus(500);
    }

    public function test_get_status_by_date_not_found(): void
    {
        $request = $this->get(
            route('transactionLog.getStatusByDate', ''),
            ['Accept' => 'application/json']);

        $request->assertStatus(404);
    }
}
