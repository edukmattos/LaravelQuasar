<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\V1\Entities\Company;

/**
 * Class CompanyTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanyTransformer extends TransformerAbstract
{
    /**
     * Transform the Company entity.
     *
     * @param \App\Entities\Company $model
     *
     * @return array
     */
    public function transform(Company $model)
    {
        return [
            'id'                => (int) $model->id,
            'full_name'         => $model->full_name,
            'name'              => $model->name,
            'einssa'            => $model->einssa,
            'business_type'  => [
                'id' => $model->business_type_id,
                'code'  => $model->business_type->code,
                'description'  => $model->business_type->description
            ],
            /* place your other model properties here */

            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at
        ];
    }
}
