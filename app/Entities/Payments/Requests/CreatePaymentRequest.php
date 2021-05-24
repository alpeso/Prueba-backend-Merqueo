<?php

namespace App\Entities\CashRegisters\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreatePaymentRequest
 * 
 * @author Alexander Pedrozo Solano
 */
class CreatePaymentRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'amount_payable' => 'in:100000,50000,20000,10000,5000,1000,500,200,100,50|required|integer',            
            'customer_payment' => 'required|integer|gte:amount_payable',            
            'payment_denomination' => 'required|in:coin,bill',
        ];
    }
}
