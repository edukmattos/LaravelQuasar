<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\OrderNoteRepository;
use App\Api\V1\Entities\OrderNote;
use App\Api\V1\Validators\OrderNoteValidator;

/**
 * Class OrderNoteRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class OrderNoteRepositoryEloquent extends BaseRepository implements OrderNoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderNote::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OrderNoteValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
