<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Article;

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

    /**
     * @return array
     */
    public function getInventoryAttribute()
    {
        if ($this->type->id != 1)
        {
        //        Traigo todos los movimientos que han enviado articulos hacia este almacen

            $in = DB::table('movements')
                ->select(DB::raw('article_id, SUM(quantity) AS totalIn'))
                ->where('status_id', '=', 1)
                ->where('destination_id', '=', $this->id)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();


//        Traigo todos los movimientos que han sacado articulos de este almacen
            $out = DB::table('movements')
                ->select(DB::raw('article_id, SUM(quantity) AS totalOut'))
                ->where('status_id', '=', 1)
                ->where('origin_id', '=', $this->id)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

            $inventory = Array();

            foreach ($in as $movIn) {
                /*            Busco cada articulo que tuvo una entrada al almacén en el arreglo de articulos
                            que salieron del almacén y resto
                */
                foreach ($out as $movOut) {
                    if ($movIn->article_id == $movOut->article_id) {
                        $inventory[$movIn->article_id] = [$movIn->article_id => $movIn->totalIn - $movOut->totalOut];
                        break;
                    } else {
                        //                    Si el articulo no ha tenido salidas, el total es lo que entró
                        $inventory[$movIn->article_id] = [$movIn->article_id => $movIn->totalIn];
                    }
                }
            }

//        Armo un arreglo con el nombre del articlulo, su id y cantidad
            foreach ($inventory as $article) {
                $key = key($article);
                $art = Article::find($key);
                $result[$key] = [$art->name => $article[$key]];
            }


        } else
        {
//            Si es un almacen de sistema, devuevo lista de articulos activos
            $all = DB::table('articles')
                ->select('id', 'name')
                ->where('active', '=', 1)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($all as $art)
            {
                $result[$art->id] = [$art->name => 999999];
            }

        }

        return $result;
    }
}
