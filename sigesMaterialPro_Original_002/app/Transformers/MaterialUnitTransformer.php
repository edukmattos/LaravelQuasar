<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MaterialUnit;

/**
 * Class MaterialUnitTransformer.
 *
 * @package namespace App\Transformers;
 */
class MaterialUnitTransformer extends TransformerAbstract
{
    /**
     * Transform the MaterialUnit entity.
     *
     * @param \App\Entities\MaterialUnit $model
     *
     * @return array
     */
    public function transform(MaterialUnit $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
