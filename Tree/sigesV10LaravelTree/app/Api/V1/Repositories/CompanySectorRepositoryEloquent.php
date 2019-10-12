<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\CompanySectorRepository;
use App\Api\V1\Entities\CompanySector;
use App\Api\V1\Validators\CompanySectorValidator;

/**
 * Class CompanySectorRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class CompanySectorRepositoryEloquent extends BaseRepository implements CompanySectorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanySector::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CompanySectorValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
