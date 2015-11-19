<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    /**
     * Los campos que se pueden llenar desde el formulario, los demás se asignan por programación
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'activity_id',
        'type_id',
        'active',
        'company_id'
    ];

    protected $dates = ['deleted_at'];
/*    public function getWarehouseListAttribute()
    {
        $warehouseList = Array();
        $warehouses = Auth::user()->warehousesList;
//        Tomo solo los valores que necesito de la Collection y los pongo en
//        un array para poblar el combobox en la vista
        foreach ($warehouses as $warehouse)
        {
            $warehouseList[$warehouse->id] = $warehouse->name;
        }

        return $warehouseList;
    }*/


    /**
     * Retorna la compañía a la que pertenece el almacen
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Retorna el tipo de almacen
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    /**
     * Retorna la actividad a la que pertenece un almacen
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }


}
