<?php

namespace App\Api\V1\Transformers;

use App\Api\V1\Entities\Company;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\BusinessTypeTransformer;

/**
 * Class CompanyTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class CompanyTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'business_type'
    ];
    
    /**
     * Transform the Company entity.
     *
     * @param \App\Api\V1\Entities\Company $model
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
            'deleted'           => false,
            'created_at'        => $model->created_at,
            'updated_at'        => $model->updated_at
        ];
    }

    public function includeBusinessType(Company $model) {
        $business_type = $model->business_type;
        return $this->item($business_type, new BusinessTypeTransformer);
    }

}
