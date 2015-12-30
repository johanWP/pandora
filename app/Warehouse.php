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

        $result = Array();
        if ($this->type->id != 1)
        {
        //        Traigo todos los movimientos que han enviado articulos hacia este almacen

            $in = DB::table('movements')
                ->select(DB::raw('article_id, SUM(quantity) AS totalIn'))
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('destination_id', '=', $this->id)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

//        Traigo todos los movimientos que han sacado articulos de este almacen
            $out = DB::table('movements')
                ->select(DB::raw('article_id, SUM(quantity) AS totalOut'))
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
                    $result[$art->id] = [
                            'id' => $art->id,
                            'name' => $art->name,
                            'fav' => $art->fav,
                            'product_code' => $art->product_code,
                            'serializable' => $art->serializable,
                            'cantidad' => $total
                        ];

                } else  // Si no hay movimientos de salida desde este almacén
                {
                    $result[$art->id] = [
                        'id' => $art->id,
                        'name' => $art->name,
                        'fav' => $art->fav,
                        'product_code' => $art->product_code,
                        'serializable' => $art->serializable,
                        'cantidad' => $movIn->totalIn
                    ];
                }
            }   // fin del foreach($in as $movIn)

        } else
        {
//            Si es un almacen de sistema, devuevo lista de articulos activos
//              que incluye articulos de todas las compañias si el usuario pertenece a una empresa parent
//dd(Auth::user()->company->parent);
            if(Auth::user()->company->parent==1)
            {
                $all = DB::table('articles')
                    ->select('id', 'name', 'serializable', 'fav')
                    ->where('active', '=', 1)
                    ->orderBy('name', 'asc')
                    ->get();
            } else {
                $all = DB::table('articles')
                    ->select('id', 'name', 'serializable', 'fav')
                    ->where('active', '=', 1)
                    ->where('company_id', '=', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get();
            }

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
        ksort($result);
        return $result;
    }
}
