<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;
use App\Company;
use App\Activity;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Warehouse;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditsController extends Controller
{

    /* Muestra los serializados duplicados
    * select id,article_id,serial,origin_id,destination_id from movements where serial<>'' and status_id=1 order by serial,id limit 10;
    */
    public function showSerializados()
    {
        //set_time_limit(600);
        //ini_set('memory_limit', '128M');
        // traigo todos los movimientos aprobados de serializados

        $myoffset = 0;

        $serializados = Movement::where('serial', '<>', '')->
        where('status_id', '1')->
        orderBy('serial')->
        orderBy('id')->
        offset($myoffset)->
        limit(20000)->
        get();

        $last_article_id = '';
        $last_serial = '';
        $last_origin_id = '';
        $last_destination_id = '';

        foreach ($serializados as $s) {
            // Analizo vs movimiento anterior

            // 1 - movimientos duplicados
            if ($s->serial == $last_serial and $s->origin_id == $last_origin_id and $s->destination_id == $last_destination_id) {

                $results[$s->id] = [
                    'id' => $s->id,
                    'article_id' => $s->article_id,
                    'serial' => $s->serial,
                    'origin_id' => $s->origin_id,
                    'destination_id' => $s->destination_id
                ];

                // } // fin movimientos duplicados

                // 2 - movimientos donde el almacen de destino anterior no coincide con el origen del inmediato siguiente
                // no necesariamente incorrectos, hay equipos recuperados o de bajas que vuelven a la calle por instalaciones, etc
                // es un elseif para no traer los duplicados
            } elseif ($s->serial == $last_serial and $s->origin_id != $last_destination_id) {

                $manuales[$s->id] = [
                    'id' => $s->id,
                    'article_id' => $s->article_id,
                    'serial' => $s->serial,
                    'origin_id' => $s->origin_id,
                    'destination_id' => $s->destination_id
                ];

            } // fin movimientos sin secuencia correcta

            $last_article_id = $s->article_id;
            $last_serial = $s->serial;
            $last_origin_id = $s->origin_id;
            $last_destination_id = $s->destination_id;

        }
        return view('audits.serializados', compact('results', 'manuales'));
    }


    /* Para un almacén específico busco los seriados y analiza inconsistencias
    * 86; 
    * OK 532 12/4;
    */
    public function showSerializadosPorAlmacen(Request $request)
    {

        // traigo todos los movimientos aprobados de serializados
        $warehouse_id = $request->id;

        $seriales = Movement::where('serial', '<>', '')->
        where('status_id', '1')->
        where(function ($q) use ($warehouse_id) {
            $q->where('origin_id', $warehouse_id)
                ->orWhere('destination_id', $warehouse_id);
        })->
        groupBy('serial')->
        get();

        foreach ($seriales as $serial) {

            $serializados = Movement::where('serial', $serial->serial)->
            where('status_id', '1')->
            orderBy('id')->
            get();

            $last_article_id = '';
            $last_serial = '';
            $last_origin_id = '';
            $last_destination_id = '';

            foreach ($serializados as $s) {
                // Analizo vs movimiento anterior

                // 1 - movimientos duplicados
                if ($s->serial == $last_serial and $s->origin_id == $last_origin_id and $s->destination_id == $last_destination_id and $s->article_id == $last_article_id) {

                    $results[$s->id] = [
                        'id' => $s->id,
                        'article_id' => $s->article_id,
                        'serial' => $s->serial,
                        'origin_id' => $s->origin_id,
                        'destination_id' => $s->destination_id
                    ];

                    // } // fin movimientos duplicados

                    // 2 - movimientos donde el almacen de destino anterior no coincide con el origen del inmediato siguiente
                    // no necesariamente incorrectos, hay equipos recuperados o de bajas que vuelven a la calle por instalaciones, etc
                    // es un elseif para no traer los duplicados
                } elseif ($s->serial == $last_serial and $s->origin_id != $last_destination_id) {

                    $manuales[$s->id] = [
                        'id' => $s->id,
                        'article_id' => $s->article_id,
                        'serial' => $s->serial,
                        'origin_id' => $s->origin_id,
                        'destination_id' => $s->destination_id
                    ];

                } // fin movimientos sin secuencia correcta

                $last_article_id = $s->article_id;
                $last_serial = $s->serial;
                $last_origin_id = $s->origin_id;
                $last_destination_id = $s->destination_id;

            }
        }
        return view('audits.serializadosporalmacen', compact('results', 'manuales'));
    }


    /* Busca qué artículos tuvieron movmimientos en los ultimos 6 meses
    * Desactiva los que no tuvieron para reducir las listas
    * 
    */
    public function desactivateArticles(Request $request)
    {
        $movimientos = Movement::where('status_id', '1')->
        where('created_at', '>', '2018-01-01')->
        groupBy('article_id')->
        get();

        $ii = 0;
        foreach ($movimientos as $m) {

            $articulos = Article::where('id', $m->article_id)->
            get();

            foreach ($articulos as $a)
                $results[$ii] = [
                    'id' => $a->id,
                    'name' => $a->name,
                    'product_code' => $a->product_code
                ];

            $ii++;
        }
        return view('audits.articulosdesactivados', compact('results'));
    }

}
