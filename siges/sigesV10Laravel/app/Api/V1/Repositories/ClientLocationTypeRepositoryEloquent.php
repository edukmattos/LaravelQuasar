<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientLocationTypeRepository;
use App\Api\V1\Entities\ClientLocationType;
use App\Api\V1\Validators\ClientLocationTypeValidator;

/**
 * Class ClientLocationTypeRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientLocationTypeRepositoryEloquent extends BaseRepository implements ClientLocationTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientLocationType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientLocationTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
