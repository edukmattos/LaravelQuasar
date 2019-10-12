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
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
