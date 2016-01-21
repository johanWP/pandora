<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    //
    public function showSettings()
    {
        $companies = \App\Company::all()->lists('name','id');
        $current_company = \App\Company::find(Auth::user()->current_company);
//        dd($current_company);
        return view('settings.settings', compact('companies', 'current_company'));
    }

    public function cambiarEmpresa(Request $request)
    {
        $response='';
        $user = \App\User::findOrFail(Auth::user()->id);

        $result = $user->update(['current_company_id' => $request->newCompany]);
//        dd($result);
        if ($result)
        {
            $response = 1;
        } else
        {
            $response =0;
        }
        return $response;
    }
}
