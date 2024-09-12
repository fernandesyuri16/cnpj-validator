<?php

namespace App\Http\Requests\CnpjValidator;

use Illuminate\Foundation\Http\FormRequest;

class StoreCnpjValidatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => 'required|unique:cnpj_validators|max:150',
            'cnpj' => 'required|max:14'
        ];
    }
}
