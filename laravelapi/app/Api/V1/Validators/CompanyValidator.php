<?php

namespace App\Api\V1\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CompanyValidator.
 *
 * @package namespace App\Api\V1\Validators;
 */
class CompanyValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'full_name' => 'required',
            'name' => 'required',
            'einssa' => 'cnpj_cpf',
            'business_type_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'full_name' => 'required',
            'name' => 'required',
            'einssa' => 'cnpj_cpf',
            'business_type_id' => 'required'
        ],
    ];
}
