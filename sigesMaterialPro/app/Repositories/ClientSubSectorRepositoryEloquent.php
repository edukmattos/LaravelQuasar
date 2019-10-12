<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ClientSubSectorRepository;
use App\Entities\ClientSubSector;
use App\Validators\ClientSubSectorValidator;

/**
 * Class ClientSubSectorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ClientSubSectorRepositoryEloquent extends BaseRepository implements ClientSubSectorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientSubSector::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
