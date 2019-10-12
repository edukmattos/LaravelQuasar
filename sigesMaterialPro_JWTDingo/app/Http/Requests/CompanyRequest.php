<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        #$business_type_id = FormRequest::get('business_type_id');

        #dd($business_type_id);

        return [
            'full_name' => 'required',
            'name' => 'required',
            'einssa' => 'cnpj_cpf',
            'business_type_id' => 'required'
        ];
    }
}
