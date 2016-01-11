<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateMovementRequest;
use Auth;
use App\Movement;
use App\Company;
use App\User;
use Redirect;
use Session;
use Illuminate\Support\Facades\DB;
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

        if (Auth::user()->company->parent == 0)
        {
            $companies = [
                        'id' => Auth::user()->company->id,
                        'name' => Auth::user()->company->name
                        ];
        } else
        {
            $companies = Company::lists('name', 'id');
        }

        $activities = DB::table('activities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('movements.create', compact('companies', 'activities'));
    }

    public function alta()
    {

        if (Auth::user()->company->parent == 0)
        {
            $companies = [
                'id' => Auth::user()->company->id,
                'name' => Auth::user()->company->name
            ];
        } else
        {
            $companies = Company::lists('name', 'id');
        }

        $activities = DB::table('activities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('movements.alta', compact('companies', 'activities'));
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
        $mov = new Movement($request->all());
        $mov->user_id = Auth::user()->id;
        $mov->status_id = $status_id;

//dd($mov);
        $valid = $this->validateMov($mov);
        //dd($valid);
        if ($valid != '')
        {
            session()->flash('flash_message_danger', 'Movimiento no ha sido creado.' . $valid);
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
            session()->flash('flash_message_important', true);
            return Redirect::to('movimientos/create')->withInput();
        } else
        {
            Movement::create($mov->toArray());
            session()->flash('flash_message', 'Movimiento creado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//            session()->flash('flash_message_important', true);
            return Redirect::to('movimientos');
        }


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
//        dd($movement);
        if($movement->approved_by !=null)
        {
            $approved = User::find($movement->approved_by);
        }
        if($movement->deleted_by !=null)
        {
            $deleted = User::find($movement->deleted_by);
        }
        return view('movements.ver', compact('movement', 'approved', 'deleted'));
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

    /** Valida el movimiento antes de insertarlo, devuelve un string vacío si no hay errores
     * @param Movement $m
     * @return string
     */
    private function validateMov(Movement $m)
    {
        $msg = '';

        if ($m->origin->active != 1)
        {
            $msg .= '<li>El almacén de origen se encuentra inactivo.</li>';
        }
        if ($m->destination->active != 1)
        {
            $msg .= '<li>El almacén de destino se encuentra inactivo.</li>';
        }
        if((Auth::user()->securityLevel < 20) AND ($m->destination->type_id != 1))
        {
            $msg .= '<li>Usted no puede hacer movimientos hacia este tipo de almacén.</li>';
        }

        if (($m->origin->type_id == 2) AND ($m->destination->type_id == 2))
        {
            $msg .= '<li>Los movimientos entre almacenes móviles no están permitidos.</li>';
        }

        if (($m->origin->type_id == 1) AND ($m->destination->type_id == 1))
        {
            $msg .= '<li>Los movimientos entre almacenes de sistema no están permitidos.</li>';
        }
        if($m->origin == $m->destination)
        {
            $msg .= '<li>Los almacenes de origen y destinos son iguales</li>';
        }

        if(($m->origin->type_id == 2) AND ($m->destination->type_id == 2))
        {
            $msg .= '<li>No se puede realizar un movimiento entre dos almacenes móviles</li>';
        }

        if ($m->origin->activity_id != $m->destination->activity_id)
        {
            $msg .= '<li>Los almacenes de origen y destino son de líneas de negocios diferentes</li>';
        }
        if (($m->origin->type_id == 1) && ($m->destination->type_id == 1))
        {
            $msg .= '<li>Los almacenes de origen y destino son de tipo "Sistema"</li>';
        }
/*
        if ($m->origin->active != 1)
        {
            $msg .= '<li>El almacén de origen no se encuentra activo.</li>';
        }
        if ($m->destination->active != 1)
        {
            $msg .= '<li>El almacén de destino no se encuentra activo.</li>';
        }
*/
        if(($m->article->serializable == 1) && ($m->serial == ''))
        {
            $msg .= '<li>Debe incluir el serial del artículo</li>';
        }

        if(($m->article->serializable==1) AND ($m->serial!='') AND ($m->origin->type_id != 1))
        {
            $lastMovement = $this->lastMovement($m->serial);
            //dd($lastMovement);
            if($lastMovement->destination_id != $m->origin_id)
            {
                $msg .= '<li>El artículo no se encuentra en el almacén '. $m->origin->name .'.
                         Verifique el serial del equipo.</li>';
            }
        }


        if ($msg != '')
        {
            $msg = '<ul>' . $msg . '</ul>';
        }
        return $msg;
    }

    /**
     * Devuelve el ultimo movimiento APROBADO del articulo con el serial indicado
     * retorna un movimiento vacío si no se encuentran movimientos del artículo
     * @param $serial
     * @return Movement
     */
    private function lastMovement($serial)
    {

        $mov = Movement::where('serial','=', $serial)
            ->where('status_id', '=', 1)
            ->orderBy('id', 'desc')
            ->first();

        if(is_null($mov))
        {
            $mov = new Movement;
        }
        return $mov;
    }
}
