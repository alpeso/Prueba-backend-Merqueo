<?php

namespace App\Entities\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SignUpRequest
 * 
 * @author Alexander Pedrozo Solano
 */
class SignUpRequest extends FormRequest
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
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string'
        ];
    }
}
