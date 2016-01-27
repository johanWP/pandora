<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function autocomplete($table)
    {

        $term = Input::get('term');

        $results = array();

        if ($table <> 'users') {
            $queries = DB::table($table)
                ->where('company_id', '=', Auth::user()->current_company_id)
                ->where('name', 'LIKE', '%' . $term . '%')
                ->take(10)->get();
            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->id, 'value' => $query->name];
            }
        } else {
            $queries = DB::table($table)
                ->where('company_id', '=', Auth::user()->current_company_id)
                ->where(function ($query) {
                    $term = Input::get('term');
                    $query->where('firstName', 'LIKE', '%' . $term . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $term . '%')
                        ->orWhere('username', 'LIKE', '%' . $term . '%');
                })

                ->take(10)->get();
            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->id, 'value' => $query->firstName.' '.$query->lastName];
            }
        }


        return ($results);
    }

    public function name2Id()
    {
        $table = Input::get('object');
        $name = Input::get('name');


        $query = DB::table($table)->select('id')
            ->where('name', '=', $name)
            ->first();
        if(empty($query))
        {
            dd($query);
        }
        $id = $query->id;

        return $id;
    }

    public function autocompleteBuscarEquipo()
    {
        $term = Input::get('term');
        $results = array();
        $queries = Movement::where('serial', 'LIKE', '%' . $term . '%')
            ->take(10)->get();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->serial];
        }
        return ($results);
    }
}
