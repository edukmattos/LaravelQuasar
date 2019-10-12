<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\ClientType;

/**
 * Class ClientTypeTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientType entity.
     *
     * @param \App\Api\V1\Entities\ClientType $model
     *
     * @return array
     */
    public function transform(ClientType $model)
    {
        return [
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'description'   => $model->description
        ];
    }
}
