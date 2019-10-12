<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BusinessTypeRepository;
use App\Entities\BusinessType;
use App\Validators\BusinessTypeValidator;

/**
 * Class BusinessTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
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
