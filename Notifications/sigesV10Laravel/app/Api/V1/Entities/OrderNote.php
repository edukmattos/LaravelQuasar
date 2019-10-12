<?php

namespace App\Api\V1\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderNote.
 *
 * @package namespace App\Api\V1\Entities;
 */
class OrderNote extends Model implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
