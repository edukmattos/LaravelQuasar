<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\Client;

/**
 * Class ClientTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{
    /**
     * Transform the Client entity.
     *
     * @param \App\Api\V1\Entities\Client $model
     *
     * @return array
     */
    public function transform(Client $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
