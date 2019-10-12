<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TenantConnectionRepository;
use App\Entities\TenantConnection;
use App\Validators\TenantConnectionValidator;

/**
 * Class TenantConnectionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TenantConnectionRepositoryEloquent extends BaseRepository implements TenantConnectionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TenantConnection::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
