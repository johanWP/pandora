<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Warehouse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    //
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

    public function articles()
    {
        $articles = Article::select('product_code', 'name', 'active', 'barcode')
            ->where('company_id', '=', Auth::user()->company->id)
            ->orderBy('name')
            ->get();
        return view('reports.articles', compact('articles'));
    }

    public function inventory()
    {
        $warehouses = Warehouse::all();

        foreach ($warehouses as $w)
        {
          if($w->type_id != 1)
          {
              $result[$w->id] = [
                  'id' => $w->id,
                  'name' => $w->name,

                  'description' => $w->description,
                  'inventory' => $w->inventory
              ];
          }
        }
//dd($result);
        return view('reports.inventory', compact('result'));

    }
}
