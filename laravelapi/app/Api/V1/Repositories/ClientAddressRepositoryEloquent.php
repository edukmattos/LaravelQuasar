<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientAddressRepository;
use App\Api\V1\Entities\ClientAddress;
use App\Api\V1\Validators\ClientAddressValidator;

/**
 * Class ClientAddressRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientAddressRepositoryEloquent extends BaseRepository implements ClientAddressRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientAddress::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientAddressValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
