<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\ClientAddress;

/**
 * Class ClientAddressTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientAddressTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientAddress entity.
     *
     * @param \App\Api\V1\Entities\ClientAddress $model
     *
     * @return array
     */
    public function transform(ClientAddress $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
