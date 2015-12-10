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
   }    /**
     * Retorna una lista json de los almacenes que tiene permitidos el usuario de un cierto tipo
     * @return json
     */
    public function warehousesType($id)
    {
        $result = Array();
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

    public function articlesSerial()
    {
        $destination =94;
        $article_id = 105;
        $m = DB::table('movements')
            ->where('destination_id', '=', $destination)
            ->where('article_id', '=', $article_id)
            ->where('status_id', '=', 1)
            ->orderBy('id', 'desc');
//            ->first();
//        $m = Movement::find(36);
        dd($m);
        return $result;
    }
}
