<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ClientSectorRepository;
use App\Entities\ClientSector;
use App\Validators\ClientSectorValidator;

/**
 * Class ClientSectorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
