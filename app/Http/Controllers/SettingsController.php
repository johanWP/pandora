<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\Movement;

class SettingsController extends Controller
{
    //
    public function showSettings()
    {
        $companies = Company::all()->lists('name','id');
        $current_company = Company::find(Auth::user()->current_company);
//        dd($current_company);
        return view('settings.settings', compact('companies', 'current_company'));
    }

    public function cambiarEmpresa(Request $request)
    {
        $response='';
        $user = User::findOrFail(Auth::user()->id);

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

    public function showFindInactiveArticles()
    {
        return view('settings.findInactiveArticlesForm');
    }

    public function findInactiveArticles(Request $request)
    {
        $desde= date_format(date_create($request->fechaDesde),"Y/m/d H:i:s");
        $hasta= date_format(date_create($request->fechaHasta),"Y/m/d 23:59:99");
        $inactivos=0;
        $active = Movement::select('article_id')->
                distinct()->
                where('created_at', '>', $desde)->
                where('created_at', '<', $hasta)->
                get();
        $activos = $active->count();
        $articles = Article::whereNotIn('id', $active)->get();
//        dd($articles);
        foreach($articles as $article)
        {
            $inactivos++;
            $article->update(['active'=>0]);
//            dd($article);
        }
        return view('settings.findInactiveArticles', compact('activos', 'inactivos'));
    }
}
