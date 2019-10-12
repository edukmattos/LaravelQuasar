<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientTypeRepository;
use App\Api\V1\Entities\ClientType;
use App\Api\V1\Validators\ClientTypeValidator;

/**
 * Class ClientTypeRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientTypeRepositoryEloquent extends BaseRepository implements ClientTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
