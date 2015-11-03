<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    //
    public function dashboard()
    {
        $user = \Auth::user();
        return view('dashboard', compact('user'));
    }

    public function inactive()
    {

        return view('pages.inactive');
    }
}
