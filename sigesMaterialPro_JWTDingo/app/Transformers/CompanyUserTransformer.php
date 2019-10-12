<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CompanyUser;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanyUserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(CompanyUser $model)
    {
        return [
            'id' => (int) $model->id,
            /* place your other model properties here */
            'name' => $model->company->name,
            'einssa' => $model->company->einssa,
            'created' => date('d/m/Y', strtotime($model->company->created_at))
        ];
    }
}
