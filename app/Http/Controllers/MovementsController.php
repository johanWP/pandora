<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateMovementRequest;
use Auth;
use App\Warehouse;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Array_;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouseList = Array();
//        user()->warehouseList se define en el modelo User
        $warehouses = Auth::user()->warehouseList;
//        Tomo solo los valores que necesito de la Collection y los pongo en
//        un array para poblar el combobox en la vista
        foreach ($warehouses as $warehouse)
        {
            $warehouseList[$warehouse->id] = $warehouse->name;
        }

        return view('movements.create', compact('warehouseList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMovementRequest $request)
    {

        Movement::create($request->all());
        session()->flash('flash_message', 'Movimiento creado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('usuarios');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
