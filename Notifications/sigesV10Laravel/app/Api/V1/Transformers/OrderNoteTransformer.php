<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\OrderNote;

/**
 * Class OrderNoteTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class OrderNoteTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderNote entity.
     *
     * @param \App\Api\V1\Entities\OrderNote $model
     *
     * @return array
     */
    public function transform(OrderNote $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
