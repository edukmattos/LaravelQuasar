<?php

namespace App\Api\V1\Transformers;

use App\Api\V1\Entities\User;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\CompanyTransformer;

/**
 * Class CompanyTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'companies'
    ];
    
    /**
     * Transform the User entity.
     *
     * @param \App\Api\V1\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'                => (int) $model->id,
            'name'              => $model->name,
            'email'             => $model->email,
            'role'              => $model->role,
            'created_at'        => $model->created_at,
            'updated_at'        => $model->updated_at,
            'access' => [
                'token'       => $model->token,
                'type'        => $model->type,
                'expires_in'  => $model->expires_in
            ]
        ];
    }

    public function includeCompanies(User $model) {
        $companies = $model->companies;
        return $this->collection($companies, new CompanyTransformer);
    }
}
