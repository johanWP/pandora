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

        Excel::create('Maestro de Artículos', function($excel) {

            $excel->sheet('Articulos', function($sheet) {

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articles()
    {
        $articles = Article::orderBy('name')->get();
        return view('reports.articles', compact('articles'));
    }

    /** Muestra el formulario del reporte de Artículos por Almacén
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showArticulosPorAlmacen()
    {
        $activities = Auth::user()->activities;
        if (Auth::user()->company->parent == 0)
        {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else
        {
            $companies = Company::lists('name', 'id');
        }

        return view('reports.articulosPorAlmacenForm', compact('activities', 'companies'));
    }
    /**
     * Devueve el inventario de articulos en cada uno de los almacenes seleccionados
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articulosPorAlmacen(Request $request)
    {
        $company_id = $request->companyList;
        if ($request->rdOrigin == 'all')
        { // Si quiero ver todos los almacenes
            $warehouses = Warehouse::where('company_id', $company_id)->
                                    where('activity_id', $request->rdActivity)->
                                    where('type_id', '<>', '1')->
                                    orderBy('name')->
                                    get();
            foreach ($warehouses as $w)
            {
                $result[$w->id] = [
                    'id' => $w->id,
                    'name' => $w->name,
                    'description' => $w->description,
                    'inventory' => $w->inventory
                ];
            }
        } else
        {   // Si quiero ver un almacén en particular
            $warehouses = Warehouse::findOrFail($request->warehouse);
            $result[$warehouses->id] = [
                'id' => $warehouses->id,
                'name' => $warehouses->name,
                'description' => $warehouses->description,
                'inventory' => $warehouses->inventory
            ];
        }
        return view ('reports.articulosPorAlmacen', compact('result'));

    }

    public function excelArticulosPorAlmacen($id)
    {
        if ($id != 'all')
        {
            $report = Excel::create('Auditoría de Almacén ', function($excel) use($id)  {

                $excel->sheet('Articulos', function($sheet) use ($id) {
                    $data = Array();
                    $name = Auth::user()->firstName.' '.Auth::user()->lastName;
                    $warehouse = Warehouse::findOrFail($id);
                    $data[] = [
                        'Código',
                        'Nombre',
                        'Cantidad',
                        'Serial'
                    ];
                    foreach($warehouse->inventory as $articulo)
                    {

                        if($articulo['serializable']==0)
                        {
                            $data[] = [
                                $articulo['product_code'],
                                $articulo['name'],
                                $articulo['cantidad'],
                                '--'
                            ];
                        } else
                        {
                            foreach($articulo['seriales'] as $item)
                            {
                                $data[] = [
                                    $articulo['product_code'],
                                    $articulo['name'],
                                    '1',
                                    $item->serial
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
                        'Fecha: ', \Carbon\Carbon::now('America/Argentina/Buenos_Aires'),
                        ));
                    $sheet->prependRow(1, array('Auditoría de '.$warehouse->name));

                    $sheet->cells('A1', function($cells)
                    {
                        $cells->setFontSize(18);
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A2:F3', function($cells)
                    {
                        $cells->setFontSize(16);
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A4:F4', function($cells)
                    {
                        $cells->setFontSize(14);
                    });
                    $sheet->cells('A5:D5', function($cells)
                    {
                        $cells->setFontWeight('bold');
                    });

                });
            })->export('xlsx');
        }

    }
    /**
     * Muestra el formulario para el reporte de movimientos por almacén
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMovimientosPorAlmacen()
    {
//        dd(Auth::user()->company);
        if (Auth::user()->company->parent == 0)
        {
            $companies = ['id' => Auth::user()->company->id, 'name' => Auth::user()->company->name];
        } else
        {
            $companies = Company::lists('name', 'id');
        }
        $activities = DB::table('activities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('reports.movimientosPorAlmacenForm',compact('companies', 'activities'));
    }

    public function movimientosPorAlmacen(Request $request)
    {

        $desde= date_format(date_create($request->fechaDesde),"Y/m/d H:i:s");
        $hasta= date_format(date_create($request->fechaHasta),"Y/m/d 23:59:99");

        if ($request->rdOrigin == 'one')
        {
            $origin_id[] = $request->origin;
        } else
        {
            $warehouses = Warehouse::select('id')->
                where('company_id',$request->companyList)->
                where('activity_id', $request->rdActivity)->
                get();
            foreach ($warehouses as $warehouse)
            {
                $origin_id[] = $warehouse->id;
            }
        }

        if ($request->rdDestination == 'one')
        {
            $destination_id[] = $request->destination;
        } else
        {
            $warehouses = Warehouse::select('id')->
                    where('company_id',$request->companyList)->
                    where('activity_id', $request->rdActivity)->
                    get();
            foreach ($warehouses as $warehouse)
            {
                $destination_id[] = $warehouse->id;
            }
        }
        $movements = Movement::where('created_at', '>=', $desde)->
                            where('created_at', '<=', $hasta)->
                            whereIn('origin_id', $origin_id)->
                            whereIn('destination_id', $destination_id)->
                            whereIn('status_id', [1,2,4])->
                            get();
        return view('reports.movimientosPorAlmacen', compact('movements'));
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
                        whereIn('status_id', [1,2,4])->
                        orderBy('id', 'desc')->
                        lists('ticket', 'ticket');

        return view('reports.movimientosPorTicketForm', compact('companies', 'tickets'));
    }

    public function movimientosPorTicket(Request $request)
    {

        $desde= date_format(date_create($request->fechaDesde),"Y/m/d H:i:s");
        $hasta= date_format(date_create($request->fechaHasta),"Y/m/d 23:59:99");

        if($request->rdTicket == 'all')
        {
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
                        whereIn('status_id', [1,2,4])->
                        orderBy('ticket', 'desc')->
                        get();
        } else
        {
            $movements = Movement::where('ticket', $request->ticket)->
                        whereIn('status_id', [1,2,4])->
                        orderBy('id', 'desc')->
                        get();
        }
//        dd($mov);
        return view('reports.movimientosPorTicket', compact('movements'));
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

        $desde= date_format(date_create($request->fechaDesde),"Y/m/d H:i:s");
        $hasta= date_format(date_create($request->fechaHasta),"Y/m/d 23:59:99");

        if($request->rdUser == 'all')
        {
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
                    whereIn('status_id', [1,2,4])->
                    orderBy('user_id', 'desc')->
                    get();
        } else
        {
            $movements = Movement::where('user_id', $request->user)->
                    whereIn('status_id', [1,2,4])->
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
        $title = 'Últimos movimientos de MAC '.$serial;
        return view('movements.index', compact('movements', 'title'));
    }

    public function showBuscarEquipo()
    {
        return view('reports.buscarEquipoForm');
    }
}
