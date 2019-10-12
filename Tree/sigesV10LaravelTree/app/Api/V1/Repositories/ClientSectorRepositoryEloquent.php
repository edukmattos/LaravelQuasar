<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\ClientSectorRepository;
use App\Api\V1\Entities\ClientSector;
use App\Api\V1\Validators\ClientSectorValidator;

/**
 * Class ClientSectorRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class ClientSectorRepositoryEloquent extends BaseRepository implements ClientSectorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientSector::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClientSectorValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
