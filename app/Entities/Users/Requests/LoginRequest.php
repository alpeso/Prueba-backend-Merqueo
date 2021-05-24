<?php

namespace App\Entities\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 * 
 * @author Alexander Pedrozo Solano
 */
class LoginRequest extends FormRequest
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
            'email'       => 'required|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean'
        ];
    }
}
