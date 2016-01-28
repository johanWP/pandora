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
        if(Auth::user()->activities != '')
        {
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
       $result = Array();
/*
        if(Auth::user()->activities != '')
        {
            $warehouses = Auth::user()->warehouseList;
            if (!empty($warehouses)) {
                foreach ($warehouses as $w)
                {
                   if($w['type_id'] == $id)
                   {
                       $result[$w['id']] = $w;
                   }
                }
            }

            return ($result);
        }
        */

        $warehouses = Warehouse::where('type_id', $request->type_id)
                    ->where('activity_id', $request->rdActivity)
                    ->where('company_id', $request->company_id)
                    ->where('active', '1')
                    ->get();
        return $warehouses;
   }
    public function warehousesActivity($id)
    {
        $result = Array();
        if(Auth::user()->activities != '')
        {
            $warehouses = Auth::user()->warehouseList;
            if (!empty($warehouses)) {
                foreach ($warehouses as $w)
                {
                   if($w['activity_id'] == $id)
                   {
                       $result[$w['id']] = $w;
                   }
                }
            }

            return ($result);
        }
   }

    /**
     * Devuelve lista de almacenes filtrados por compañía y actividad
     * @param Request $request
     * @return Warehouses
     */
    public function warehousesByActivity(Request $request)
    {
//        $company_id = $request->company_id;
        $warehouses = Warehouse::where('company_id', $request->company_id)
                                ->where('activity_id', $request->rdActivity)
                                ->where('active', '1')
                                ->orderBy('name')
                                ->get();

//        dd($warehouses);
        return $warehouses;
    }
    /**
     * Retorna un arreglo json de los articulos disponibles en el almacen
     * @param $warehouse_id
     * @return json
     */

    public function articlesAvailable($warehouse_id)
    {
        $warehouse = Warehouse::findOrFail($warehouse_id);
        return $warehouse->inventory;
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
