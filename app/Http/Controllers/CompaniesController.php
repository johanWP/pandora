<?php

namespace App\Http\Controllers;

use App\Company;
use Auth;
use App\Activity;
use Redirect;
use App\Http\Requests;
use App\Http\Requests\CompanyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\HttpResponse;

/**
 * Class CompaniesController
 * @package App\Http\Controllers
 */
class CompaniesController extends Controller
{
    //
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::orderBy('name', 'asc')->paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.ver', compact('company'));
    }

    public function create()
    {
//        Busco un arreglo de actividades que trae los nombre y los ID
        $activities = Activity::lists('name', 'id');
        return view('companies.create', compact('activities'));
    }

    /**
     * @param Requests\CreateCompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CompanyRequest $request)
    {

        Company::create($request->all());

        return Redirect::to('empresas');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $activities = Activity::lists('name', 'id');
        return view('companies.edit', compact('company', 'activities'));
    }

    public function update($id, CompanyRequest $request)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return Redirect::to('empresas');
    }
}
