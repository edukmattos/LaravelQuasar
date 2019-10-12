<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\Order;

/**
 * Class OrderTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    /**
     * Transform the Order entity.
     *
     * @param \App\Api\V1\Entities\Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
