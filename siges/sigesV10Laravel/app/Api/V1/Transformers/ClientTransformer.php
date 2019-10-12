<?php

namespace App\Api\V1\Transformers;

use App\Api\V1\Entities\Client;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\ClientTypeTransformer;
use App\Api\V1\Transformers\ClientStatusTransformer;
use App\Api\V1\Transformers\ClientLocationTransformer;

/**
 * Class ClientTransformer.
 *
 * @package namespace App\Api\V1\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'client_type',
        'client_status',
        'client_locations'
    ];
    
    /**
     * Transform the Client entity.
     *
     * @param \App\Api\V1\Entities\Client $model
     *
     * @return array
     */
    public function transform(Client $model)
    {
        return [
            'id'                => (int) $model->id,
            'full_name'         => $model->full_name,
            'name'              => $model->name,
            'einssa'            => $model->einssa,
            'email'             => $model->email,
            'mobile'            => $model->mobile,
            'phone'             => $model->phone,
            'deleted'           => false,
            'created_at'        => $model->created_at,
            'updated_at'        => $model->updated_at
        ];
    }

    public function includeClientType(Client $model) {
        $client_type = $model->client_type;
        return $this->item($client_type, new ClientTypeTransformer);
    }

    public function includeClientStatus(Client $model) {
        $client_status = $model->client_status;
        return $this->item($client_status, new ClientStatusTransformer);
    }

    public function includeClientLocations(Client $model) {
        $client_locations = $model->client_locations;
        return $this->collection($client_locations, new ClientLocationTransformer);
    }
}
