<?php

namespace Tests\Feature\app\Http\Controllers\Api\CashRegisters;

use App\Entities\CashRegisters\CashRegister;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CashRegisterControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    public function test_create_money_base_cash_register_success(): void
    {
        $user = User::factory()->create();
        
        $this->actingAs($user, 'api');
        
        $dataArray = [
            'denomination' => 'bill',
            'value' => '20000',
            'quantity' => '1'
        ];

        $request = $this->post(route('cashRegister.create'), $dataArray, ['Accept' => 'application/json']);

        $request->assertStatus(200);

        $this->assertDatabaseHas('cash_registers', $dataArray);
    }

    public function test_create_money_base_cash_register_required_fields_error(): void
    {
        $request = $this->post(route('cashRegister.create'), [], ['Accept' => 'application/json']);

        $request->assertStatus(422);
    }

    public function test_withdraw_all_money_cash_register_success(): void
    {
        CashRegister::factory(5)->create();

        $request = $this->get(route('cashRegister.withdrawAllMoney'), ['Accept' => 'application/json']);

        $request->assertStatus(200)->assertJsonStructure([
            'status', 
            'message'
        ]);
    }

    public function test_withdraw_all_money_cash_register_error(): void
    {
        $request = $this->get(route('cashRegister.withdrawAllMoney'), ['Accept' => 'application/json']);

        $request->assertStatus(500)->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_check_status_cash_register_success(): void
    {
        CashRegister::factory(9)->create();

        $request = $this->get(route('cashRegister.checkStatus'), ['Accept' => 'application/json']);

        $request->assertStatus(200)->assertJsonStructure([
            'status',
            'message' => [
                'total_cash_register',
                'coin',
                'total_coin',
                'bill',
                'total_bill'
            ]
        ]);

    }
}
