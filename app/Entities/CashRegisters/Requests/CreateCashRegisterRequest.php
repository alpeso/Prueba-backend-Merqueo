<?php

namespace App\Entities\Payments\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCashRegisterRequest
 * 
 * @author Alexander Pedrozo Solano
 */
class CreateCashRegisterRequest extends FormRequest
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
            'denomination' => 'required|in:coin,bill',
            'value'        => $this->input('denomination') === 'coin' ? 'in:500,200,100,50|required|integer': 'in:100000,50000,20000,10000,5000,1000|required|integer',
            'quantity'     => 'required'
        ];
    }
}
