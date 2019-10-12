<?php

namespace App\Api\V1\Entities;

use App\Api\V1\Entities\Client;
use App\Api\V1\Entities\ClientLocationType;
use Venturecraft\Revisionable\Revisionable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ClientLocation.
 *
 * @package namespace App\Api\V1\Entities;
 */
class ClientLocation extends Revisionable implements Transformable
{
    use TransformableTrait;
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //protected $table = 'client_locations';
    
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 9999999; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = [];
    #protected $revisionFormattedFields = array('title'  => 'string:<strong>%s</strong>', 'public' => 'boolean:No|Yes', 'deleted_at' => 'isEmpty:Active|Deleted');
    protected $revisionFormattedFieldNames = [
        'client_id' => 'Cliente',
        'client_location_type_id' => 'Iipo',
        'main'  => 'Principal',
		'code'  => 'Código',
        'description' => 'Descrição',           
        'address' => 'Endereço',
        'building' => 'Nr predial',
        'building_comments' => 'Complemento',
        'neighborhood' => 'Bairro',
        'zip_code' => 'CEP',
        'city' => 'Cidade',
        'state' => 'UF',
        'phone' => 'Telefone',
        'mobile' => 'Celular',
        'email' => 'e-mail', 
        'comments' => 'Observações',
        'lat' => 'Latitude',
        'lng' => 'Longetude',
        'deleted_at' => 'Excluído'
    ];
    protected $revisionNullString = 'nada';
    protected $revisionUnknownString = 'desconhecido';
    public function identifiableName() 
    {
        return $this->description;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'client_location_type_id',
        'main',
		'code',
        'description',  
        'address',
        'building',
        'building_comments',
        'zip_code',
        'neighborhood',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'comments',
        'lat',
        'lng'
    ];

    public function client_location_type()
    {
        return $this->belongsTo(ClientLocationType::class); 
    }

    public function client()
    {
        return $this->belongsTo(Client::class); 
    }
}