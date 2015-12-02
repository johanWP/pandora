<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\Type;
use App\Http\Requests;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::orderBy('name', 'asc')->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activities = Activity::lists('name', 'id');
        $activities->prepend('Seleccione una actividad');

        $types = Type::lists('name', 'id');
        $types->prepend('Seleccione un tipo de almacén');
        return view('warehouses.create', compact('activities', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWarehouseRequest $request)
    {
//        dd($request->input());
        $w = new Warehouse($request->all());
        $w->company_id = Auth::user()->company_id;
        Warehouse::create($w->toArray());
        session()->flash('flash_message', 'Almacén creado correctamente.');
        return Redirect::to('almacenes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $company = $warehouse->company;
        $activity = $warehouse->activity;
        $type = $warehouse->type;
        return view('warehouses.ver', compact('warehouse', 'company', 'activity','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $activities = Activity::lists('name', 'id');
        $types = Type::lists('name', 'id');
        return view('warehouses.edit', compact('warehouse', 'activities', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWarehouseRequest $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->all());
        session()->flash('flash_message', 'Almacén Actualizado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('almacenes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
        session()->flash('flash_message_danger', 'Almacén borrado correctamente.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('almacenes');
    }

}
