<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientStatusRepository;
use App\Api\V1\Entities\ClientStatus;
use App\Api\V1\Validators\ClientStatusValidator;

/**
 * Class ClientStatusRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientStatusRepositoryEloquent extends BaseRepository implements ClientStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientStatus::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientStatusValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
