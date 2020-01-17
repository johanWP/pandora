<?php

namespace App\Http\Controllers;

use App\Movement;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Company;
use App\Activity;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Warehouse;
use App\User;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    //
    /**
     * Exporta el Listado de todos los articulos en formato Excel
     */
    public function excelArticles()
    {

        Excel::create('Maestro de Artículos', function ($excel) {

            $excel->sheet('Articulos', function ($sheet) {

                $articles = Article::select('product_code', 'name', 'active', 'barcode')
                    ->orderBy('name')
                    ->get();

                $sheet->fromArray($articles);

            });
        })->export('xlsx');
    }

    /**
     * Devuelve un listado de articulos
     * Si el usuario logueado pertenece a una empresa parent, el listado devulve la lista de
     * articulos de current_company
     * @return Factory|View
     */
    public function articles()
    {
        $articles = Article::orderBy('name')->get();
        return view('reports.articles', compact('articles'));
    }

    /** Muestra el formulario del reporte de Artículos por Almacén
     *
     * @return Factory|View
     */
    public function showArticulosPorAlmacen()
    {
        $activities = Auth::user()->activities;
        if (Auth::user()->company->parent == 0) {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else {
            $companies = Company::lists('name', 'id');
        }

        return view('reports.articulosPorAlmacenForm', compact('activities', 'companies'));
    }

    /**
     * Devuelve el inventario de articulos en cada uno de los almacenes seleccionados
     * @return Factory|View
     */
    public function articulosPorAlmacen(Request $request)
    {

        // extiendo el tiempo de ejecucion
        set_time_limit(600);
        ini_set('memory_limit', '128M');

        $company_id = $request->companyList;
        if ($request->rdOrigin == 'all') { // Si quiero ver todos los almacenes
            $warehouses = Warehouse::where('company_id', $company_id)->
            where('activity_id', $request->rdActivity)->
            where('type_id', '<>', '1')->
            orderBy('name')->
            get();
            foreach ($warehouses as $w) {
                $result[$w->id] = [
                    'id' => $w->id,
                    'name' => $w->name,
                    'description' => $w->description,
                    'inventory' => $w->inventory
                ];
            }
        } else {   // Si quiero ver un almacén en particular
            $warehouses = Warehouse::findOrFail($request->warehouse);
            $result[$warehouses->id] = [
                'id' => $warehouses->id,
                'name' => $warehouses->name,
                'description' => $warehouses->description,
                'inventory' => $warehouses->inventory
            ];
        }
        return view('reports.articulosPorAlmacen', compact('result'));

    }

    public function excelArticulosPorAlmacen($id)
    {
        if ($id != 'all') {
            $report = Excel::create('Auditoría de Almacén ', function ($excel) use ($id) {

                $excel->sheet('Articulos', function ($sheet) use ($id) {
                    $data = Array();
                    $name = Auth::user()->firstName . ' ' . Auth::user()->lastName;
                    $warehouse = Warehouse::findOrFail($id);
                    $data[] = [
                        'Código',
                        'Nombre',
                        'Cantidad',
                        'Serial'
                    ];
                    foreach ($warehouse->inventory as $articulo) {

                        if ($articulo['serializable'] == 0) {
                            $data[] = [
                                $articulo['product_code'],
                                $articulo['name'],
                                $articulo['cantidad'],
                                '--'
                            ];
                        } else {
                            foreach ($articulo['seriales'] as $item) {
                                $data[] = [
                                    $articulo['product_code'],
                                    $articulo['name'],
                                    '1',
                                    $item
                                ];
                            }
                        }
                    }
                    $sheet->fromArray($data);
                    $sheet->setColumnFormat(array(
                        'A' => '@',
                        'B' => '@',
                        'C' => '0',
                        'C' => '@',
                    ));
                    $sheet->prependRow(1, array(
                        'Auditado por:', $name,
                    ));
                    $sheet->prependRow(1, array(
                        'Fecha: ', Carbon::now('America/Argentina/Buenos_Aires'),
                    ));
                    $sheet->prependRow(1, array('Auditoría de ' . $warehouse->name));

                    $sheet->cells('A1', function ($cells) {
                        $cells->setFontSize(18);
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A2:F3', function ($cells) {
                        $cells->setFontSize(16);
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A4:F4', function ($cells) {
                        $cells->setFontSize(14);
                    });
                    $sheet->cells('A5:D5', function ($cells) {
                        $cells->setFontWeight('bold');
                    });

                });
            })->export('xlsx');
        }

    }


    /* Articulos por almacen optimizado */
    public function showArticulosPorAlmacenAlt()
    {
        $activities = Auth::user()->activities;
        if (Auth::user()->company->parent == 0) {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else {
            $companies = Company::lists('name', 'id');
        }

        return view('reports.articulosPorAlmacenFormAlt', compact('activities', 'companies'));
    }

    /**
     * Devuelve el inventario de articulos en cada uno de los almacenes seleccionados
     * @return Factory|View
     */
    public function articulosPorAlmacenAlt(Request $request)
    {

        $company_id = $request->companyList;
        if ($request->rdOrigin == 'all') { // Si quiero ver todos los almacenes
            $warehouses = Warehouse::where('company_id', $company_id)->
            where('activity_id', $request->rdActivity)->
            where('type_id', '<>', '1')->
            orderBy('name')->
            get();
            foreach ($warehouses as $w) {
                $result[$w->id] = [
                    'id' => $w->id,
                    'name' => $w->name,
                    'description' => $w->description,
                    'inventory' => $w->inventorybasic
                ];
            }
        } else {   // Si quiero ver un almacén en particular
            $warehouses = Warehouse::findOrFail($request->warehouse);
            $result[$warehouses->id] = [
                'id' => $warehouses->id,
                'name' => $warehouses->name,
                'description' => $warehouses->description,
                'inventory' => $warehouses->inventorybasic
            ];
        }
        return view('reports.articulosPorAlmacenAlt', compact('result'));

    }

    public function showSeriadosPorAlmacen(Request $request)
    {

        $warehouse = Warehouse::findOrFail($request->id);

        $article_id = DB::table('articles')
            ->where('product_code', '=', $request->article)
            ->where('serializable', '=', 1)
            ->where('active', '=', 1)
            ->first();

        $result = Array();

        // Traigo todos los movimientos que han enviado articulos hacia este almacen
        $in = DB::table('movements')
            ->select('serial', 'created_at')
            ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
            ->where('article_id', '=', $article_id->id)
            ->where('destination_id', '=', $request->id)
            //->whereNotNull('serial')
            //->latest()
            ->get();

        // Los convierto en Collection para poder filtrar
        $in = collect($in);
        $i = 0;

        foreach ($in as $movIn) {
            // Traigo todos los movimientos que han sacado articulos de este almacen
            $isout = DB::table('movements')
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('serial', '=', $movIn->serial)
                ->where('article_id', '=', $article_id->id)
                ->where('origin_id', '=', $request->id)
                ->where('created_at', '>', $movIn->created_at)
                ->whereIn('status_id', [1, 2])
                ->latest()
                ->get();

            $isout = collect($isout);

            if ($isout->isEmpty()) {

                // no hay salidas mas nuevas, escribo result
                $result[$i] = [
                    'article_id' => $article_id->product_code,
                    'article_desc' => $article_id->name,
                    'serial' => $movIn->serial
                ];

                $i++;

            }

        }   // fin del foreach($in as $movIn)

        // Mando la lista de almacenes autorizados para los movimientos rápidos en esta vista
        $wh = DB::table('warehouses')
            ->select('id', 'name')
            ->where('company_id', '=', $warehouse->company_id)
            ->where('id', '!=', $request->id)
            ->where('active', '=', 1)
            ->orderBy('name')
            ->get();

        //$wh = collect($wh);
        $aid = $article_id->id;


        return view('reports.seriadosPorAlmacenAlt', compact('warehouse', 'result', 'wh', 'aid'));

    }


    public function showInventarioPorAlmacen()
    {
        $activities = Auth::user()->activities;
        if (Auth::user()->company->parent == 0) {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else {
            $companies = Company::lists('name', 'id');
        }

        return view('reports.inventarioPorAlmacenForm', compact('activities', 'companies'));
    }

    public function inventarioPorAlmacen(Request $request)
    {
        // metodo alternativo para mostrar un inventario, sin seriales

        $company_id = $request->companyList;
        if ($request->rdOrigin == 'all') { // Si quiero ver todos los almacenes

            $warehouses = Warehouse::where('company_id', $company_id)->
            where('activity_id', $request->rdActivity)->
            where('type_id', '<>', '1')->
            orderBy('name')->
            get();
            foreach ($warehouses as $w) {
                $result[$w->id] = [
                    'id' => $w->id,
                    'name' => $w->name,
                    'description' => $w->description
                ];
            }

        } else { // Para un almacen en particular
            $result = Array();
            // Traigo todos los movimientos que han enviado articulos hacia este almacen

            $in = DB::table('movements')
                ->select(DB::raw('id,article_id, serial,SUM(quantity) AS totalIn'))
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('destination_id', '=', $request->warehouse)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

            // Traigo todos los movimientos que han sacado articulos de este almacen

            $out = DB::table('movements')
                ->select(DB::raw('id,article_id, serial,SUM(quantity) AS totalOut'))
                ->whereIn('status_id', [1, 2])     // status 1: Aprobado, Status 2: por aprobar
                ->where('origin_id', '=', $request->warehouse)
                ->groupBy('article_id')
                ->orderBy('article_id', 'asc')
                ->get();

            // Los convierto en Collection para poder filtrar por article_id
            $in = collect($in);
            $out = collect($out);

            foreach ($in as $movIn) {
                $art = Article::find($movIn->article_id);
                $filtered = $out->filter(function ($item) use ($movIn) {
                    return $item->article_id == $movIn->article_id;
                });

                if ($filtered->count() > 0) {
                    $movOut = $filtered->first();
                    $total = $movIn->totalIn - $movOut->totalOut;
                } else  // Si no hay movimientos de salida desde este almacén
                {
                    $total = $movIn->totalIn;
                }

                if ($total > 0) {
                    $result[$art->id] = [
                        'id' => $art->id,
                        'name' => $art->name,
                        'fav' => $art->fav,
                        'product_code' => $art->product_code,
                        'serializable' => $art->serializable,
                        'cantidad' => $total
                    ];
                }


            }   // fin del foreach($in as $movIn)
        }
        return view('reports.inventarioPorAlmacen', compact('result'));

    }

    /**
     * Muestra el formulario para el reporte de movimientos por almacén
     * @return Factory|View
     */
    public function showMovimientosPorAlmacen()
    {
//        dd(Auth::user()->company);
        if (Auth::user()->company->parent == 0) {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else {
            $companies = Company::lists('name', 'id');
        }
        $activities = DB::table('activities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('reports.movimientosPorAlmacenForm', compact('companies', 'activities'));
    }

    public function movimientosPorAlmacen(Request $request)
    {

        $desde = date_format(date_create($request->fechaDesde), "Y/m/d H:i:s");
        $hasta = date_format(date_create($request->fechaHasta), "Y/m/d 23:59:59");

        // establezco el almacen de origen y destino dentro de un arreglo / todos o uno especifico
        if ($request->rdOrigin == 'one') {
            $origin_id[] = $request->origin;
        } else {
            $warehouses = Warehouse::select('id')->
            where('company_id', $request->companyList)->
            where('activity_id', $request->rdActivity)->
            get();
            foreach ($warehouses as $warehouse) {
                $origin_id[] = $warehouse->id;
            }
        }

        if ($request->rdDestination == 'one') {
            $destination_id[] = $request->destination;
        } else {
            $warehouses = Warehouse::select('id')->
            where('company_id', $request->companyList)->
            where('activity_id', $request->rdActivity)->
            get();
            foreach ($warehouses as $warehouse) {
                $destination_id[] = $warehouse->id;
            }
        }
        $movements = Movement::where('created_at', '>=', $desde)->
        where('created_at', '<=', $hasta)->
        whereIn('origin_id', $origin_id)->
        whereIn('destination_id', $destination_id)->
        whereIn('status_id', [1, 2, 4])->
        get();

        $company = $request->companyList;
        return view('reports.movimientosPorAlmacen', compact('movements', 'company'));
    }

    //

    /**
     * Exporta el Listado de todos los movimientos en formato Excel
     */
    public function excelMovimientosPorAlmacen(Request $request)
    {

        $desde = date_format(date_create($request->fechaDesde), "Y/m/d H:i:s");
        $hasta = date_format(date_create($request->fechaHasta), "Y/m/d 23:59:59");
        $actividad = $request->rdActivity;
        $company_id = $request->company_id;

        Excel::create('Movimientos de Artículos por Almacen', function ($excel) use ($desde, $hasta, $actividad, $company_id) {

            $excel->sheet('Movimientos', function ($sheet) use ($desde, $hasta, $actividad, $company_id) {

                // Format column as number
                $sheet->setColumnFormat(array(
                    'F' => '0'
                ));

                $warehouses = Warehouse::select('id')->
                where('company_id', $company_id)->
                where('activity_id', $actividad)->
                get();
                foreach ($warehouses as $warehouse) {
                    $destination_id[] = $warehouse->id;
                }

                $movements = Movement::select('created_at', 'origin_id', 'destination_id', 'article_id', 'serial', 'quantity', 'ticket', 'remito', 'user_id', 'approved_by', 'deleted_by', 'status_id', 'note')
                    ->where('created_at', '>=', $desde)
                    ->where('created_at', '<=', $hasta)
                    ->whereIn('origin_id', $destination_id)
                    ->whereIn('destination_id', $destination_id)
                    ->orderBy('created_at')
                    ->get();

                // cambio arreglo para buscar los nombres de los id

                foreach ($movements as $key => $value) {
                    $art = Article::find($value['article_id']);
                    $movements[$key]['article_id'] = $art->name;

                    $origin = Warehouse::find($value['origin_id']);
                    $movements[$key]['origin_id'] = $origin->name;

                    $destination = Warehouse::find($value['destination_id']);
                    $movements[$key]['destination_id'] = $destination->name;

                    $user = User::find($value['user_id']);
                    $movements[$key]['user_id'] = $user->firstName . ' ' . $user->lastName;

                    if ($value['approved_by']) {
                        $approved = User::find($value['approved_by']);
                        $movements[$key]['approved_by'] = $approved->firstName . ' ' . $approved->lastName;
                    }

                    if ($value['deleted_by']) {
                        $deleted = User::find($value['deleted_by']);
                        $movements[$key]['deleted_by'] = $deleted->firstName . ' ' . $deleted->lastName;
                    }

                    if ($value['status_id'] == 1) {
                        $movements[$key]['status_id'] = 'Aprobado';
                    }
                    if ($value['status_id'] == 2) {
                        $movements[$key]['status_id'] = 'Por Aprobar';
                    }
                    if ($value['status_id'] == 3) {
                        $movements[$key]['status_id'] = 'Eliminado';
                    }
                    if ($value['status_id'] == 4) {
                        $movements[$key]['status_id'] = 'Rechazado';
                    }

                }

                $sheet->fromArray($movements);

            });
        })->export('xlsx');
    }


    public function showMovimientosPorTicket()
    {
        $companies = Company::lists('name', 'id');

//       1) Traigo todos los almacenes que pertenecen a la compañía del usuario
        $arrayW = collect(DB::table('warehouses')->
        select('id')->
        where('company_id', Auth::user()->current_company_id)->
        get());
//      2) Traigo el campo "ticket" de los movimientos sobre los almacenes seleccionados
//        para pre cargar el dropdown
        $tickets = Movement::select('ticket')->
        distinct()->
        whereIn('origin_id', $arrayW->lists('id')->toArray())->
        whereIn('status_id', [1, 2, 4])->
        orderBy('ticket', 'desc')->
        lists('ticket', 'ticket');

        return view('reports.movimientosPorTicketForm', compact('companies', 'tickets'));
    }

    public function movimientosPorTicket(Request $request)
    {

        $desde = date_format(date_create($request->fechaDesde), "Y/m/d H:i:s");
        $hasta = date_format(date_create($request->fechaHasta), "Y/m/d 23:59:99");

        if ($request->rdTicket == 'all') {
//      1) Traigo todos los almacenes (que no han sido borrados) que pertenecen a la compañía seleccionada
            $arrayW = collect(DB::table('warehouses')->
            select('id')->
            whereNull('deleted_at')->
            where('company_id', $request->companyList)->
            get());
//      2) Traigo todos los movimientos sobre esos almacenes, ordenados por ticket
            $movements = Movement::whereIn('origin_id', $arrayW->lists('id')->toArray())->
            where('created_at', '>=', $desde)->
            where('created_at', '<=', $hasta)->
            whereIn('status_id', [1, 2, 4])->
            orderBy('ticket', 'desc')->
            get();
        } else {
            $movements = Movement::where('ticket', $request->ticket)->
            whereIn('status_id', [1, 2, 4])->
            orderBy('id', 'desc')->
            get();
        }
//        dd($mov);
        return view('reports.movimientosPorTicket', compact('movements'));
    }



    //

    /**
     * Exporta el Listado de todos los movimientos de un ticket específico en formato Excel
     */
    public function excelMovimientosPorTicket(Request $request)
    {

        $ticket = $request->ticket;

        Excel::create('Movimientos de Artículos por Almacen', function ($excel) use ($ticket) {

            $excel->sheet('Movimientos', function ($sheet) use ($ticket) {

                $movements = Movement::select('created_at', 'origin_id', 'destination_id', 'article_id', 'serial', 'quantity', 'ticket', 'remito', 'user_id', 'approved_by', 'deleted_by', 'status_id', 'note')
                    ->where('ticket', '=', $ticket)
                    ->orderBy('created_at')
                    ->get();

                // cambio arreglo para buscar los nombres de los id
                foreach ($movements as $key => $value) {
                    $art = Article::find($value['article_id']);
                    $movements[$key]['article_id'] = $art->name;

                    $origin = Warehouse::find($value['origin_id']);
                    $movements[$key]['origin_id'] = $origin->name;

                    $destination = Warehouse::find($value['destination_id']);
                    $movements[$key]['destination_id'] = $destination->name;

                    $user = User::find($value['user_id']);
                    $movements[$key]['user_id'] = $user->firstName . ' ' . $user->lastName;

                    if ($value['approved_by']) {
                        $approved = User::find($value['approved_by']);
                        $movements[$key]['approved_by'] = $approved->firstName . ' ' . $approved->lastName;
                    }

                    if ($value['deleted_by']) {
                        $deleted = User::find($value['deleted_by']);
                        $movements[$key]['deleted_by'] = $deleted->firstName . ' ' . $deleted->lastName;
                    }

                    if ($value['status_id'] == 1) {
                        $movements[$key]['status_id'] = 'Aprobado';
                    }
                    if ($value['status_id'] == 2) {
                        $movements[$key]['status_id'] = 'Por Aprobar';
                    }
                    if ($value['status_id'] == 3) {
                        $movements[$key]['status_id'] = 'Eliminado';
                    }
                    if ($value['status_id'] == 4) {
                        $movements[$key]['status_id'] = 'Rechazado';
                    }

                }

                $sheet->fromArray($movements);

            });
        })->export('xlsx');
    }


    public function showMovimientosPorUsuario()
    {
        $companies = Company::lists('name', 'id');
//       Traigo todos los almacenes que pertenecen a la compañía del usuario
        $arrayW = collect(DB::table('warehouses')->
        select('id')->
        where('company_id', Auth::user()->current_company_id)->
        get());
//      Traigo todos los usuarios que no han sido borrados, y que pertenecen a la empresa seleccionada por el usuario
//        para precargar el dropdown
        $users = DB::table('users')->
        select(DB::raw('concat(firstName, " ", lastName) as name, id'))->
        whereNull('deleted_at')->
        where('company_id', Auth::user()->current_company_id)->
        lists('name', 'id');

        return view('reports.movimientosPorUsuarioForm', compact('companies', 'users'));
    }

    public function movimientosPorUsuario(Request $request)
    {

        $desde = date_format(date_create($request->fechaDesde), "Y/m/d H:i:s");
        $hasta = date_format(date_create($request->fechaHasta), "Y/m/d 23:59:99");

        if ($request->rdUser == 'all') {
//       Traigo todos los almacenes (que no han sido borrados) que pertenecen a la compañía seleccionada por usuario
            $arrayW = collect(DB::table('warehouses')->
            select('id')->
            whereNull('deleted_at')->
            where('company_id', $request->companyList)->
            get());
//       Traigo todos los movimientos sobre los almacenes seleccionados
            $movements = Movement::whereIn('origin_id', $arrayW->lists('id')->toArray())->
            where('created_at', '>=', $desde)->
            where('created_at', '<=', $hasta)->
            whereIn('status_id', [1, 2, 4])->
            orderBy('user_id', 'desc')->
            get();
        } else {
            $movements = Movement::where('user_id', $request->user)->
            whereIn('status_id', [1, 2, 4])->
            orderBy('id', 'desc')->
            get();
        }
        return view('reports.movimientosPorUsuario', compact('movements'));
    }

    public function buscarEquipo($serial)
    {
        $movements = Movement::where('serial', $serial)->
        orderBy('id', 'desc')->
        paginate(20);
        $title = 'Últimos movimientos de MAC ' . $serial;
        return view('movements.index', compact('movements', 'title', 'serial'));
    }

    public function showBuscarEquipo()
    {
        return view('reports.buscarEquipoForm');
    }
}
