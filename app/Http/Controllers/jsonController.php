<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
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
     * Retorna un arreglo json de los articulos disponibles en el almacen
     * @param $warehouse_id
     * @return json
     */

    public function articlesAvailable($warehouse_id)
    {
        $warehouse = Warehouse::findOrFail($warehouse_id);
        return $warehouse->inventory;
    }
}
