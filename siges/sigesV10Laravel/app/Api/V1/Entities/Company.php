<?php

namespace App\Api\V1\Entities;

use App\Api\V1\Entities\User;
#use App\Tenant\Models\Tenant;
#use App\Tenant\Traits\IsTenant;
#use App\Tenant\Traits\ForSystem;
use App\Api\V1\Entities\BusinessType;
use Venturecraft\Revisionable\Revisionable;
#use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Company.
 *
 * @package namespace App\Entities;
 */
class Company extends Revisionable implements Transformable
{
    use TransformableTrait;
    #use IsTenant, ForSystem;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 9999999; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = [];
    #protected $revisionFormattedFields = array('title'  => 'string:<strong>%s</strong>', 'public' => 'boolean:No|Yes', 'deleted_at' => 'isEmpty:Active|Deleted');
    protected $revisionFormattedFieldNames = [
        'full_name' => 'Razão Social/Nome completo',
        'name' => 'Fantasia/Apelido',
        'einssa' => 'CPF/CNPJ',
        'business_type_id' => 'Ramo de Atividade',
        'deleted_at' => 'Excluído'
    ];
    protected $revisionNullString = 'nada';
    protected $revisionUnknownString = 'desconhecido';
    public function identifiableName() 
    {
        return $this->name;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'name',
        'uuid',
        'einssa',
        'business_type_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function business_type()
    {
        return $this->belongsTo(BusinessType::class); 
    }
}