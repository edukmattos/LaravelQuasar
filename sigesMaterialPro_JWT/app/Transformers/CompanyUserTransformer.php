<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CompanyUser;

/**
 * Class CompanyUserTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanyUserTransformer extends TransformerAbstract
{
    /**
     * Transform the CompanyUser entity.
     *
     * @param \App\Entities\CompanyUser $model
     *
     * @return array
     */
    public function transform(CompanyUser $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
