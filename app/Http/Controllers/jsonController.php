<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\Movement;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Article;

class jsonController extends Controller
{
    /**
     * Retorna una lista json de los almacenes que tiene permitidos el usuario
     * @return json
     */
    public function warehousesList()
    {
        if (Auth::user()->activities != '') {
            $warehouses = Auth::user()->warehouseList;

            return ($warehouses);
        }
    }

    /**
     * Retorna una lista json de los almacenes que tiene permitidos el usuario de un cierto tipo
     * @return json
     */
    public function warehousesByType(Request $request)
    {
        $warehouses = Warehouse::where('type_id', $request->type_id)
            ->where('activity_id', $request->rdActivity)
            ->where('company_id', $request->company_id)
            ->where('active', '1')
            ->get();
        return $warehouses;
    }

    /**
     * Devuelve lista de almacenes filtrados por compañía y actividad
     * @param Request $request
     * @return Warehouses
     */
    public function warehousesByActivity(Request $request)
    {
        /*        $warehouses = Auth::user()->
                    warehouses->
                    where('activity_id', $request->rdActivity)->
                    where('company_id', $request->company_id);*/

        $warehouses = Auth::user()->warehouses->filter(function ($item) use ($request) {
            return ($item->activity_id == $request->rdActivity AND $item->company_id == $request->company_id);
        });


        /*
                if($warehouses->count()<1)
                {
                    // Chequeo dos veces la lista de almacenes porque el query en el servidor no funciona sin convertir
                    // los parámetros a integer
                    $company_id = (int)$request->company_id;
                    $activity_id = (int)$request->rdActivity_id;
                    $warehouses = Auth::user()->warehouses->where('activity_id', $activity_id)->where('company_id', $company_id);
                }
                */
        return $warehouses;
    }

    /**
     * Retorna un arreglo json de los articulos disponibles en el almacen
     * @param $warehouse_id
     * @return json
     */

    public function articlesAvailable($warehouse_id)
    {
        // Para evitar timeout en validaciones
        set_time_limit(240);

        $warehouse = Warehouse::findOrFail($warehouse_id);
        return $warehouse->inventory;
    }

    public function articlesAvailableBasic($warehouse_id)
    {


        $warehouse = Warehouse::findOrFail($warehouse_id);
        return $warehouse->inventorybasic;
    }

    /** Devuelve el detalle de un almacén especificado
     * @param $id
     * @return Warehouse
     */
    public function warehouseDetail($id)
    {
        $w = Warehouse::findOrFail($id);
        return $w;
    }


}
