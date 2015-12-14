<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function autocomplete($table)
    {

        $term = Input::get('term');

        $results = array();

        if ($table <> 'users') {
            $queries = DB::table($table)
                ->where('name', 'LIKE', '%' . $term . '%')
                ->take(5)->get();
            foreach ($queries as $query)
            {
                $results[] = [ 'id' => $query->id, 'value' => $query->name];
            }
        } else {
            $queries = DB::table($table)
                ->where('firstName', 'LIKE', '%' . $term . '%')
                ->orWhere('lastName', 'LIKE', '%' . $term . '%')
                ->take(5)->get();
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
}
