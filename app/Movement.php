<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use App\Warehouse;
use DB;

class Movement extends Model
{
    use SoftDeletes;
    //
    protected $fillable=[
        'remito',
        'article_id',
        'origin_id',
        'serial',
        'destination_id',
        'user_id',
        'status_id',
        'quantity',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Retorna el usuario que realizó el movimiento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Retorna el articulo que se movió
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Obligo a poner el movimiento en estatus "por Aprobar" si el usuario tiene
     * securityLevel
     */
    public function setStatusIdAttribute()
    {
        if(Auth::user()->securityLevel>=20)
        {
            $status_id = 1;     // Aprobado
        } else
        {
            $status_id = 2;     // Por Aprobar
        }
         $this->attributes['status_id'] = $status_id;
    }

    /**
     * Obligo a que el valor de user_id se registre con el id del usuario logueado sin importar lo que venga
     * del formlario
     */
    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = Auth::user()->id;
    }

    /**
     * Devuelve el Warehouse de origen del movimiento con todos sus atributos
     * @return Warehouse
     */
    public function getOriginAttribute()
    {
        $origin = Warehouse::find($this->origin_id);
        return $origin;
    }

    /**
     *  Devuelve el Warehouse de destino del movimiento con todos sus atributos
     * @return Warehouse
     */
    public function getDestinationAttribute()
    {
        $destination = Warehouse::find($this->destination_id);
        return $destination;
    }
    public function getStatusAttribute()
    {
        $status = DB::table('statuses')
            ->where('id', '=', $this->status_id)
            ->first();

        return $status;
    }
}
