<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\ClientStatus;

/**
 * Class ClientStatusTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientStatusTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientStatus entity.
     *
     * @param \App\Api\V1\Entities\ClientStatus $model
     *
     * @return array
     */
    public function transform(ClientStatus $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
