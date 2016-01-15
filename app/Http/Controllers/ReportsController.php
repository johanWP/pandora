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

        Excel::create('Laravel Excel', function($excel) {

            $excel->sheet('Articulos', function($sheet) {

                $articles = Article::select('product_code', 'name', 'active', 'barcode')
                    ->where('company_id', '=', Auth::user()->company->id)
                    ->orderBy('name')
                    ->get();

                $sheet->fromArray($articles);

            });
        })->export('xlsx');
    }

    /**
     * Devuelve un listado de articulos
     * Si el usuario logueado pertenece a una empresa parent, el listado incluye los articulos de todas
     * las empresas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articles()
    {
        if(Auth::user()->company->parent==0) {
            $articles = Article::select('product_code', 'name', 'active', 'barcode')
                ->where('company_id', '=', Auth::user()->company->id)
                ->orderBy('name')
                ->get();
        } else {
            $articles = Article::select('product_code', 'name', 'active', 'barcode')
                ->orderBy('name')
                ->get();
        }
        return view('reports.articles', compact('articles'));
    }

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
     * Devueve la lista de almacenes con el inventario de articulos en cada uno de ellos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articulosPorAlmacen(Request $request)
    {
//        dd($request->all());
        $company_id = $request->companyList;
        if ($request->rdOrigin == 'all')
        {
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
        {
            $warehouses = Warehouse::findOrFail($request->warehouse);
            $result[$warehouses->id] = [
                'id' => $warehouses->id,
                'name' => $warehouses->name,

                'description' => $warehouses->description,
                'inventory' => $warehouses->inventory
            ];
        }
//        $warehouses = Warehouse::all();

//        $result = $warehouses;
//        dd($result);
        return view('reports.articulosPorAlmacen', compact('result'));

    }

    public function showListadoCumplimientoDeMaterial()
    {
        $companies = Company::lists('name', 'id');
        $activities = DB::table('activities')
                        ->select('id', 'name')
                        ->orderBy('name')
                        ->get();
//        $activities = Activity::lists('name', 'id');
//        dd($activities);
        $articles = Article::lists('name', 'id');
        //$warehouses = Warehouse::lists('name', 'id');
        return view('reports.listadoCumplimientoDeMaterialForm',compact('companies', 'articles', 'activities'));
    }

    public function listadoCumplimientoDeMaterial(Request $request)
    {
        dd($request->all());
        return view('reports.listadoCumplimientoDeMaterial');
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
            $warehouses = Warehouse::select('id')
                ->where('company_id',$request->companyList)
                ->where('activity_id', $request->rdActivity)
                ->get();
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
            $warehouses = Warehouse::select('id')
                ->where('company_id',$request->companyList)
                ->where('activity_id', $request->rdActivity)
                ->get();
            foreach ($warehouses as $warehouse)
            {
                $destination_id[] = $warehouse->id;
            }
        }
        $movements = Movement::where('created_at', '>=', $desde)
                            ->where('created_at', '<=', $hasta)
                            ->whereIn('origin_id', $origin_id)
                            ->whereIn('destination_id', $destination_id)
                            ->get();
        return view('reports.movimientosPorAlmacen', compact('movements'));
    }
}
