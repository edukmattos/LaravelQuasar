<?php

namespace App\Api\V1\Entities;

use App\Api\V1\Entities\ClientType;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\Revisionable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Client.
 *
 * @package namespace App\Api\V1\Entities;
 */
class Client extends Revisionable implements Transformable
{
    use TransformableTrait;
   
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
        'clientTypeId' => 'Ramo de Atividade',
        'clientStatusId' => 'Ramo de Atividade',
        'email' => 'E-mail',
        'mobile' => 'Celular',
        'phone' => 'Telefone',
        'birthDate' => 'Data nascimento',
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

    public function clientType()
    {
        return $this->belongsTo(ClientType::class); 
    }
}