<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BusinessType;

/**
 * Class BusinessTypeTransformer.
 *
 * @package namespace App\Transformers;
 */
class BusinessTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the BusinessType entity.
     *
     * @param \App\Entities\BusinessType $model
     *
     * @return array
     */
    public function transform(BusinessType $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
