<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\ClientSector;

/**
 * Class ClientSectorTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientSectorTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientSector entity.
     *
     * @param \App\Api\V1\Entities\ClientSector $model
     *
     * @return array
     */
    public function transform(ClientSector $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
