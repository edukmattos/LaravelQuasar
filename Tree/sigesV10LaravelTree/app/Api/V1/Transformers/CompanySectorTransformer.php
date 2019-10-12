<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\CompanySector;

/**
 * Class CompanySectorTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class CompanySectorTransformer extends TransformerAbstract
{
    /**
     * Transform the CompanySector entity.
     *
     * @param \App\Api\V1\Entities\CompanySector $model
     *
     * @return array
     */
    public function transform(CompanySector $model)
    {
        return [
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'description'   => $model->description
        ];
    }
}
