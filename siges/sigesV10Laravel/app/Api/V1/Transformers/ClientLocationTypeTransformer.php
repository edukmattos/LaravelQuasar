<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\ClientLocationType;

/**
 * Class ClientLocationTypeTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientLocationTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientLocationType entity.
     *
     * @param \App\Api\V1\Entities\ClientLocationType $model
     *
     * @return array
     */
    public function transform(ClientLocationType $model)
    {
        return [
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'description'   => $model->description
        ];
    }
}
