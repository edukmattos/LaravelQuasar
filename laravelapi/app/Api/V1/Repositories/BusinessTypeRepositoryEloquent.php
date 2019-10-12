<?php

namespace App\Api\V1\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Api\V1\Repositories\BusinessTypeRepository;
use App\Api\V1\Entities\BusinessType;
use App\Api\V1\Validators\BusinessTypeValidator;

/**
 * Class BusinessTypeRepositoryEloquent.
 *
 * @package namespace App\Api\V1\Repositories;
 */
class BusinessTypeRepositoryEloquent extends BaseRepository implements BusinessTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BusinessType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return BusinessTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function searchByDescription($terms)
	{
        $tags = explode(" ", $terms);
                
        return $this->model
            ->where(function($query) use ($tags) 
            {
                foreach($tags as $tag) 
                {
                    $query->where('description','LIKE','%'.$tag.'%');
                }
            })
            ->orderBy('description', 'asc')
            ->get();
	}
    
}
