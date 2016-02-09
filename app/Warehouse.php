<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Article;
use Illuminate\Support\Facades\Auth;

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

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    /**
     * Devuelve un arreglo con los articulos que están en un almacén con sus cantidades,
     * si el almacen es de sistema devuelve la lista completa de articulos
     * @return array
     */
    public function getInventoryAttribute()
    {

        $result = Array();
        if ($this->type->id != 1)
        {
        //        Traigo todos los movimientos que han enviado articulos hacia este almacen

            $in = DB::table('movements')
                ->select(DB::raw('id,article_id, serial,SUM(quantity) AS totalIn'))
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('destination_id', '=', $this->id)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

//        Traigo todos los movimientos que han sacado articulos de este almacen
            $out = DB::table('movements')
                ->select(DB::raw('id,article_id, serial,SUM(quantity) AS totalOut'))
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('origin_id', '=', $this->id)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

            // Los convierto en Collection para poder filtrar por article_id
            $in = collect($in);
            $out = collect($out);

            foreach ($in as $movIn)
            {
                $art = Article::find($movIn->article_id);
                $filtered = $out->filter(function ($item) use($movIn)
                {
                    return $item->article_id == $movIn->article_id;
                });

                $seriales = Array();
                if ($filtered->count() > 0)
                {
                    $movOut = $filtered->first();
                    $total = $movIn->totalIn - $movOut->totalOut;
                } else  // Si no hay movimientos de salida desde este almacén
                {
                    $total = $movIn->totalIn;
                }

                if($total >0)
                {
                    $result[$art->id] = [
                        'id' => $art->id,
                        'name' => $art->name,
                        'fav' => $art->fav,
                        'product_code' => $art->product_code,
                        'serializable' => $art->serializable,
                        'seriales' => $this->buscarSeriales($art),
                        'cantidad' => $total
                    ];
                }


            }   // fin del foreach($in as $movIn)

        } else
        {
//            Si es un almacen de sistema, devuevo lista de articulos activos
//              que incluye articulos de todas las compañias si el usuario pertenece a una empresa parent
//            if(Auth::user()->company->parent==1)
//            {
//                $all = DB::table('articles')
//                    ->select('id', 'name', 'serializable', 'fav')
//                    ->where('active', '=', 1)
//                    ->where('company_id', '=', Auth::user()->current_company_id)
//                    ->orderBy('name', 'asc')
//                    ->get();
//            } else {
                $all = DB::table('articles')
                    ->select('id', 'name', 'serializable', 'fav')
                    ->where('active', '=', 1)
                    ->orderBy('name', 'asc')
                    ->get();
//            }

            foreach ($all as $art)
            {
                $result[$art->id] =
                    [
                    'id' => $art->id,
                    'name'=>$art->name,
                    'fav' => $art->fav,
                    'serializable' => $art->serializable,
                    'cantidad' => 999999
                    ];
            }

            //dd($result);
        }
 /*****************/
        usort($result, function($a, $b) {
            // You can use an anonymous function like this for the usort comparison function.
            if ($a['name'] < $b['name']) return -1;
            if ($a['name'] == $b['name']) return 0;
            // In case of 'order' ties, you may want to add a comparison of a different key
            return 1; // $a['order'] must be > $b['order'] at this point
        });

/******************/
        return $result;
    }

    /**
     * Recibe el ID de un articulo y devuelve arreglo con los seriales de ese articulo que se encuentran
     * en el almacén actual
     * @param $art
     * @return array
     */
    private function buscarSeriales($art)
    {
        // status 1: Aprobado, Status 2: por aprobar

        if ($art->serializable=='1')
        {
            $out = Movement::select(DB::raw('DISTINCT(serial)'))->
            whereIn('status_id', [1, 2])->
            where('origin_id', '=', $this->id)->
            where('article_id', $art->id)->
            orderBy('id', 'asc')->
            get()->toArray();
            foreach ($out as $movOut) {
                $seriales[] = $movOut['serial'];
            }
            if (count($out) > 0) {
                $s = DB::table('movements')->
                select(DB::raw('DISTINCT(serial)'))->
                whereIn('status_id', [1, 2])->
                whereNotIn('serial', $seriales)->
                where('destination_id', '=', $this->id)->
                where('article_id', $art->id)->
                orderBy('id', 'asc')->
                get();

            } else {
                $s = DB::table('movements')->
                select(DB::raw('DISTINCT(serial)'))->
                whereIn('status_id', [1, 2])->
                //            whereNotIn('serial', $seriales)->
                where('destination_id', '=', $this->id)->
                where('article_id', $art->id)->
                    orderBy('id', 'asc')->
                    get();
                }
        } else
        {
            $s[]='';
        }

        return $s;
    }


}
