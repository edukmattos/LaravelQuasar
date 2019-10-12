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
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'description'   => $model->description,
            'icon_name'     => $model->icon_name,
            'icon_color'    => $model->icon_color
        ];
    }
}
