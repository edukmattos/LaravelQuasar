<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientLocationRepository;
use App\Api\V1\Entities\ClientLocation;
use App\Api\V1\Validators\ClientLocationValidator;

/**
 * Class ClientLocationRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientLocationRepositoryEloquent extends BaseRepository implements ClientLocationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientLocation::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientLocationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
