<?php

namespace App\Api\V1\Transformers;

use App\Api\V1\Entities\ClientLocation;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\ClientLocationTypeTransformer;

/**
 * Class ClientLocationTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientLocationTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'client_location_type'
    ];
    
    /**
     * Transform the ClientLocation entity.
     *
     * @param \App\Api\V1\Entities\ClientLocation $model
     *
     * @return array
     */
    public function transform(ClientLocation $model)
    {
        return [
            'id'                => (int) $model->id,
            'code'              => $model->code,
            'description'       => $model->description,
            'main'              => $model->main,
            'code'              => $model->code,
            'description'       => $model->description,           
            'address'           => $model->address,
            'building'          => $model->building,
            'building_comments' => $model->building_comments,
            'neighborhood'      => $model->neighborhood,
            'zip_code'          => $model->zip_code,
            'city'              => $model->city,
            'state'             => $model->state,
            'phone'             => $model->phone,
            'mobile'            => $model->mobile,
            'email'             => $model->email, 
            'comments'          => $model->comments,
            'lat'               => $model->lat,
            'lng'               => $model->lng,
            'deleted'           => 'false'
        ];
    }

    public function includeClientLocationType(ClientLocation $model) {
        $client_location_type = $model->client_location_type;
        return $this->item($client_location_type, new ClientLocationTypeTransformer);
    }
}
