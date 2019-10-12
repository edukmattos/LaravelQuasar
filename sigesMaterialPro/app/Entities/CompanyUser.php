<?php

namespace App\Entities;

use App\Entities\User;
use App\Entities\Company;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CompanyUser.
 *
 * @package namespace App\Entities;
 */
class CompanyUser extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "company_user";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function company()
    {
        return $this->belongsTo(Company::class); 
    }
}
