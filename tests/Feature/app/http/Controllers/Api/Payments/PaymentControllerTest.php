<?php

namespace Tests\Feature\app\Http\Controllers\Api\Payments;

use App\Entities\CashRegisters\CashRegister;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }
    public function test_create_payment_error_fields(): void
    {
        $request = $this->post(route('payment.createPayment'), [], ['Accept' => 'application/json']);

        $request->assertStatus(422);
    }

    public function test_create_payment_success():void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        CashRegister::factory()->create(['value' => 20000, 'quantity' => 2]);

        $data = [            
            'amount_payable'        => '10000',
            'customer_payment'      => '50000',
            'payment_denomination'  => 'bill'
        ];

        $request = $this->post(route('payment.createPayment'), $data, ['Accept' => 'application/json']);

        $request->assertStatus(200);
    }

    public function test_amount_payable_cannot_be_greater_than_customer_payment():void
    {
        User::factory()->create();

        $data = [            
            'amount_payable'        => '100000',
            'customer_payment'      => '50000',
            'payment_denomination'  => 'bill'
        ];

        $request = $this->post(route('payment.createPayment'), $data, ['Accept' => 'application/json']);

        $request->assertStatus(422);
    }

    public function test_there_is_not_enough_money_to_pay_back():void
    {
        User::factory()->create();

        $data = [            
            'amount_payable'        => '10000',
            'customer_payment'      => '50000',
            'payment_denomination'  => 'bill'
        ];

        $request = $this->post(route('payment.createPayment'), $data, ['Accept' => 'application/json']);

        $request->assertStatus(500);
    }

    public function test_create_payment_error_not_user():void
    {
        $data = [
            'customer_payment'      => '50000',
            'amount_payable'        => '20000',
            'payment_denomination'  => 'bill'
        ];

        $request = $this->post(route('payment.createPayment'), $data, ['Accept' => 'application/json']);

        $request->assertStatus(500);
    }
}
