<?php

namespace App\Api\V1\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ClientValidator.
 *
 * @package namespace App\Api\V1\Validators;
 */
class ClientValidator extends LaravelValidator
{
    protected $id;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Validation Rules
     *
     * @var array
     */
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'full_name' => 'required|unique:clients,full_name',
            'name' => 'required|unique:clients,name',
            'einssa' => 'cnpj_cpf|required|unique:clients,einssa',
            'email' => 'email|required|unique:clients,email',
            'mobile' => 'celular_mascara|unique:clients,mobile',
            'phone' => 'telefone_mascara|unique:clients,phone'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'full_name' => 'required|unique:clients,full_name',
            'name' => 'required|unique:clients,name',
            'einssa' => 'cnpj_cpf|required|unique:clients,einssa',
            'email' => 'email|required|unique:clients,email',
            'mobile' => 'celular_mascara|unique:clients,mobile',
            'phone' => 'telefone_mascara|unique:clients,phone'
        ]
    ];
}
