<?php

namespace App\Api\V1\Entities;

use App\Api\V1\Entities\Client;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Venturecraft\Revisionable\Revisionable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ClientType.
 *
 * @package namespace App\Api\V1\Entities;
 */
class ClientType extends Revisionable implements Transformable
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
        'code' => 'Código',
        'description' => 'Descrição',
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
        'code',
        'description'
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class); 
    }

}
