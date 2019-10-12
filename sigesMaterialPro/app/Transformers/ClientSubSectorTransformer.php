<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ClientSubSector;

/**
 * Class ClientSubSectorTransformer.
 *
 * @package namespace App\Transformers;
 */
class ClientSubSectorTransformer extends TransformerAbstract
{
    /**
     * Transform the ClientSubSector entity.
     *
     * @param \App\Entities\ClientSubSector $model
     *
     * @return array
     */
    public function transform(ClientSubSector $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
