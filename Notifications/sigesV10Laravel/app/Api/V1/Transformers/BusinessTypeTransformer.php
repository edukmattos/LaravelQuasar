<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\BusinessType;

/**
 * Class BusinessTypeTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class BusinessTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the BusinessType entity.
     *
     * @param \App\Api\V1\Entities\BusinessType $model
     *
     * @return array
     */
    public function transform(BusinessType $model)
    {
        return [
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'description'   => $model->description
        ];
    }
}
