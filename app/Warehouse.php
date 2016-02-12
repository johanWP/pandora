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

    /**
     * @return array
     */
    public function getInventoryAttribute()
    {
        $temp = Array();
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
                    $temp = $this->buscarSeriales($art);
                    $result[$art->id] = [
                        'id' => $art->id,
                        'name' => $art->name,
                        'fav' => $art->fav,
                        'product_code' => $art->product_code,
                        'serializable' => $art->serializable,
                        'seriales' => $temp,
                        'cantidad' => $total
                    ];
                }


            }   // fin del foreach($in as $movIn)

        } else
        {
//            Si es un almacen de sistema, devuevo lista de articulos activos
//              que incluye articulos de todas las compañias si el usuario pertenece a una empresa parent
            $all = DB::table('articles')
                ->select('id', 'name', 'serializable', 'fav')
                ->where('active', '=', 1)
                ->orderBy('name', 'asc')
                ->get();

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

    private function buscarSeriales($art)
    {
        // status 1: Aprobado, Status 2: por aprobar
        $s = Array();
        if ($art->serializable=='1')
        {
//            dd($art);
//            Busco todos los seriales de entrada de ese articulo en particular
            $in = Movement::select(DB::raw('serial, SUM(quantity) as totalIn'))->
            whereIn('status_id', [1, 2])->     // status 1: Aprobado, Status 2: por aprobar
            where('destination_id', '=', $this->id)->
            where('article_id', $art->id)->
            groupBy('serial')->
            orderBy('article_id', 'asc')->
            get();

//            Busco todos los seriales de ese articulo que salieron
            $out = Movement::select(DB::raw('serial, SUM(quantity) as totalOut'))->
            whereIn('status_id', [1, 2])->
            where('origin_id', '=', $this->id)->
            where('article_id', $art->id)->
            groupBy('serial')->
            orderBy('article_id', 'asc')->
            get();

            $in = collect($in);
            $out = collect($out);

            foreach($in as $movIn)
            {
                $filtered = $out->filter(function ($item) use($movIn)
                {
                    return strtoupper($item->serial) == strtoupper($movIn->serial);
                });
                if ($filtered->count() > 0)
                {  //  si ese serial salió del almacen
                    $movOut = $filtered->first();

                    if(($movIn->totalIn - $movOut->totalOut)>0)
                    {
                        $s[]=$movIn->serial;
                    }
                } else
                {
                    $s[]= $movIn->serial;
                }

            }
        } else
        {  // Esto esta porque siempre hay que devolver un arreglo, aunque el articulo no sea serializable
            $s[]='';
        }

        return $s;
    }


}
