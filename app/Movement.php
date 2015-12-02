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
        'ticket',
        'quantity',
        'user_id',
        'approved_by',
        'deleted_by',
        'status_id'
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
