<?php

namespace App\Api\V1\Entities;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CompanySector.
 *
 * @package namespace App\Api\V1\Entities;
 */
class CompanySector extends Model implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use NodeTrait;  
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description'
    ];
}
