<?php

namespace App\Api\V1\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
    #public function collection($resourceKey, array $data)
    #{
    #    dd($resourceKey);
    #    return $resourceKey === false ? $data : [$resourceKey => $data];
    #}

    #public function item($resourceKey, $data)
    #{
    #    dd($resourceKey);
    #    return $resourceKey === false ? $data : [$resourceKey => $data];
    #}

    public function collection($resourceKey, array $data)
    {
        $resourceKey = false;
        
        if ($resourceKey === false) {
            return $data;
        }

        return ['success' => true, $data];
    }

    public function item($resourceKey, array $data)
    {
        $resourceKey = false;
        
        if ($resourceKey === false) {
            return $data;
        }

        return ['success' => true, $data];
    }
}