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
        $articlesAvailable = '';
        $warehouse = Warehouse::find($warehouse_id);
//        Si el almacen es de sistema no verifico que haya existecia de articulos
//        muestro todos los activos
        if($warehouse->type_id==1)
        {
            $articles = DB::table('articles')
                    ->where('active', '=', 1)
                    ->orderBy('name')
                    ->get();
        }

        if (!empty($articles)) {
            foreach ($articles as $article)
            {
                $articlesAvailable[$article->id] = $article->name;
            }
        }
        return $articlesAvailable;
    }
}
