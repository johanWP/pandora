<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateMovementRequest;
use Auth;
use App\Movement;
use Redirect;
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
        $movements = Movement::orderBy('id', 'desc')->paginate(10);
        return view('movements.index', compact('movements'));
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
        if(Auth::user()->securityLevel>=20)
        {
            $status_id = 1;     // Aprobado
        } else
        {
            $status_id = 2;     // Por Aprobar
        }
//        $mov =Movement::create($request->all());
/*        $mov = Movement::create([
            'remito'        => $request['remito'],
            'article_id'    => $request['article_id'],
            'origin_id'     => $request['origin_id'],
            'serial'        => $request['serial'],
            'destination_id'=> $request['destination_id'],
            'user_id'       => Auth::user()->id,
            'status_id'     => $status_id,
            'quantity'      => $request['quantity'],

        ]);
*/
        $mov = new Movement($request->all());
        $mov->user_id = Auth::user()->id;
        Movement::create($mov->toArray());

        session()->flash('flash_message', 'Movimiento creado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('movimientos');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movement = Movement::findOrFail($id);
        return view('movements.ver', compact('movement'));
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
        if(Auth::user()->securityLevel >= 20) {
            $mov = Movement::findOrFail($id);
            $x =$mov->update([
                'approved_by'       => Auth::user()->id,
                'status_id'     => 1,
            ]);

            session()->flash('flash_message', 'Movimiento actualizado correctamente.');
        }
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('movimientos');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mov = Movement::findOrFail($id);
        if(Auth::user()->securityLevel >= 20) {
            $mov = Movement::findOrFail($id);
            $mov->update([
                'deleted_by'       => Auth::user()->id,
                'status_id'     => 3,
            ]);
            $mov->delete();
        }
        session()->flash('flash_message', 'Movimiento borrado correctamente.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('movimientos');
    }


}
