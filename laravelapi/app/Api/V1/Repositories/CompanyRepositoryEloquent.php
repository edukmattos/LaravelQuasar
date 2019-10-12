<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\CompanyRepository;
use App\Api\V1\Entities\Company;
use App\Api\V1\Validators\CompanyValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CompanyRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    public function validator()
    {
        return CompanyValidator::class;
    }  

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
