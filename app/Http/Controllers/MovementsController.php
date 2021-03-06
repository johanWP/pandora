<?php

namespace App\Http\Controllers;

use App\Warehouse;
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
        if (Auth::user()->securityLevel > 20)
        {
//      1) Busco todos los almacenes de la empresa que tiene seleccionada el usuario
            $arrayW = DB::table('warehouses')
                ->select('id')
                ->where('company_id', Auth::user()->current_company_id)
                ->get();
            $arrayW = collect($arrayW);
//      2) Busco los movimientos de esos almacenes
            $movements = Movement::whereIn('status_id', ['1', '2'])->
                whereIn('origin_id', $arrayW->lists('id')->toArray())->
                orderBy('id', 'desc')->
                paginate(10);
        } else
        {
//      Si es un técnico, Busco los movimientos solo de ese usuario
            $movements = Movement::whereIn('status_id', ['1', '2'])->
                where('user_id', Auth::user()->id)->
                orderBy('id', 'desc')->
                paginate(10);
        }

        $title = 'Últimos Movimientos';
        return view('movements.index', compact('movements', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Para evitar timeout en validaciones
        set_time_limit(240);
/*
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
*/
        $activities = Auth::user()->activities;
        return view('movements.create', compact('activities'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createbasic()
    {
        $activities = Auth::user()->activities;
        return view('movements.createbasic', compact('activities'));
    }
    
    public function createserial()
    {
        $activities = Auth::user()->activities;
        return view('movements.createserial', compact('activities'));
    }

    public function showAlta()
    {
        $activities = Auth::user()->activities;
        return view('movements.alta', compact('activities'));
    }

    public function alta(Request $request)
    {
        dd($request->all());
        $title = 'Últimos Movimientos';
        return view('movements.index', $title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMovementRequest $request)
    {
        $i =1;
        $arrMov = Array();
        $conErrores = '';
        if(Auth::user()->securityLevel>=20)
        {
            $status_id = 1;     // Aprobado
        } else
        {
            $status_id = 2;     // Por Aprobar
        }
        for ($i=1; $i <= $request['numArticles']; $i++)
        {

            if ($request['article_id' . $i] !='')
            {
                if ($request['serialList' . $i] != '') {
                    $serial = $request['serialList' . $i];
                } else {
                    $serial = $request['serial' . $i];
                }
                //        Crea un objeto Movement pero no lo guarda en la base de datos
                $mov = new Movement(
                    [
                        'remito' => $request['remito'],
                        'article_id' => $request['article_id' . $i],
                        'quantity' => $request['quantity' . $i],
                        'note' => $request['note' . $i],
                        'origin_id' => $request['origin_id'],
                        'destination_id' => $request['destination_id'],
                        'ticket' => $request['ticket'],
                        'serial' => $serial,
                        'status_id' => $status_id,
                        'user_id' => Auth::user()->id
                    ]
                );
                $valid = $this->validateMov($mov);
                if ($valid == '')
                {
                    //            Guarda el objeto en la base de datos
                    Movement::create($mov->toArray());

                } elseif(!strstr($conErrores, $valid))
                {
                    $conErrores .= $valid;
                }
            }

        }

        if ($conErrores == '')
        {
            session()->flash('flash_message', 'Todos los movimientos se registraron correctamente.');
            return Redirect::to('movimientos');
        } else
        {
            $conErrores = '<ul>'.$conErrores.'</ul>';
            session()->flash('flash_message_danger', 'Algunos movimientos no han sido registrados.' . $conErrores);
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
            session()->flash('flash_message_important', true);
            return Redirect::to('movimientos');
        }


    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storebasic(CreateMovementRequest $request)
    {
        $i =1;
        $arrMov = Array();
        $conErrores = '';
        if(Auth::user()->securityLevel>=20)
        {
            $status_id = 1;     // Aprobado
        } else
        {
            $status_id = 2;     // Por Aprobar
        }
        for ($i=1; $i <= $request['numArticles']; $i++)
        {

            if ($request['article_id' . $i] !='')
            {
                if ($request['serialList' . $i] != '') {
                    $serial = $request['serialList' . $i];
                } else {
                    $serial = $request['serial' . $i];
                }
                // Crea un objeto Movement pero no lo guarda en la base de datos
                $mov = new Movement(
                    [
                        'remito' => $request['remito'],
                        'article_id' => $request['article_id' . $i],
                        'quantity' => $request['quantity' . $i],
                        'note' => $request['note' . $i],
                        'origin_id' => $request['origin_id'],
                        'destination_id' => $request['destination_id'],
                        'ticket' => $request['ticket'],
                        'serial' => $serial,
                        'status_id' => $status_id,
                        'user_id' => Auth::user()->id
                    ]
                );
                $valid = $this->validateBasicMov($mov);
                if ($valid == '')
                {
                    //            Guarda el objeto en la base de datos
                    Movement::create($mov->toArray());

                } elseif(!strstr($conErrores, $valid))
                {
                    $conErrores .= $valid;
                }
            }

        }

        if ($conErrores == '')
        {
            session()->flash('flash_message', 'Todos los movimientos se registraron correctamente.');
            return Redirect::to('movimientos');
        } else
        {
            $conErrores = '<ul>'.$conErrores.'</ul>';
            session()->flash('flash_message_danger', 'Algunos movimientos no han sido registrados.' . $conErrores);
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
            session()->flash('flash_message_important', true);
            return Redirect::to('movimientos');
        }


    }
    
    
    public function storeserial(CreateMovementRequest $request)
    {
        $i =1;
        $arrMov = Array();
        $conErrores = '';
        if(Auth::user()->securityLevel>=20)
        {
            $status_id = 1;     // Aprobado
        } else
        {
            $status_id = 2;     // Por Aprobar
        }
        for ($i=1; $i <= $request['numArticles']; $i++)
        {

            if ($request['article_id' . $i] !='')
            {
                if ($request['serialList' . $i] != '') {
                    $serial = $request['serialList' . $i];
                } else {
                    $serial = $request['serial' . $i];
                }
                //        Crea un objeto Movement pero no lo guarda en la base de datos
                $mov = new Movement(
                    [
                        'remito' => $request['remito'],
                        'article_id' => $request['article_id' . $i],
                        'quantity' => $request['quantity' . $i],
                        'note' => $request['note' . $i],
                        'origin_id' => $request['origin_id'],
                        'destination_id' => $request['destination_id'],
                        'ticket' => $request['ticket'],
                        'serial' => $serial,
                        'status_id' => $status_id,
                        'user_id' => Auth::user()->id
                    ]
                );
                $valid = $this->validateSerialMov($mov);
                if ($valid == '')
                {
                    //            Guarda el objeto en la base de datos
                    Movement::create($mov->toArray());

                } elseif(!strstr($conErrores, $valid))
                {
                    $conErrores .= $valid;
                }
            }

        }

        if ($conErrores == '')
        {
            session()->flash('flash_message', 'Todos los movimientos se registraron correctamente.');
            return Redirect::to('movimientos');
        } else
        {
            $conErrores = '<ul>'.$conErrores.'</ul>';
            session()->flash('flash_message_danger', 'Algunos movimientos no han sido registrados.' . $conErrores);
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
            session()->flash('flash_message_important', true);
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
            $mov->update([
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
        // Para evitar timeout en validaciones
        set_time_limit(240);
        
        $msg = ''; $cantidad=0;

        if ($m->origin->active != 1)
        {
            $msg .= '<li>El almacén de origen se encuentra inactivo.</li>';
        }

        if ($m->destination->active != 1)
        {
            $msg .= '<li>El almacén de destino se encuentra inactivo.</li>';
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

        if ($m->origin->activity_id != $m->destination->activity_id)
        {
            $msg .= '<li>Los almacenes de origen y destino son de actividades diferentes</li>';
        }
        if(($m->article->serializable == 1) && ($m->serial == ''))
        {
            $msg .= '<li>Debe incluir el serial del '.$m->article->name.'</li>';
        }
        if(($m->article->active == 0))
        {
            $msg .= '<li>'.$m->article->name.' está marcado como inactivo. Comuníquese con el jefe de almacén.</li>';
        }

//        if(($m->article->serializable==1) AND ($m->serial!='') AND ($m->origin->type_id != 1))
        if(($m->article->serializable==1) AND ($m->serial!=''))
        {
            $lastMovement = $this->lastMovement($m->serial);
            if(!is_null($lastMovement->destination))
            {
                if(($lastMovement->destination_id != $m->origin_id) && ($lastMovement->destination->type_id!=1))
                {
                    $msg .= '<li>El artículo no se encuentra en '. $m->origin->name .'.
                         Verifique el serial del equipo.</li>';
                }
            }
        }

        if ($m->origin->type_id != 1)
        {
            $inventory = collect($m->origin->inventory);
            $filtered = $inventory->filter(function ($item) use($m)
            {
                return $item['id'] == $m->article_id;
            });
            $articulo = $filtered->first(); //dd($m->quantity);
            $cantidad = $articulo['cantidad'];
            if($m->quantity > $articulo['cantidad'] )
            {
                $msg .= '<li>No puede transferir <strong>'.$articulo['cantidad'].'</strong> '.$m->article->name.'</li>';
            }
        }

        return $msg;
    }


    /** Valida el movimiento antes de insertarlo, devuelve un string vacío si no hay errores
     * Solo no seriados, usa la funcion inventorybasic
     * @param Movement $m
     * @return string
     */
    private function validateBasicMov(Movement $m)
    {
        
        $msg = ''; $cantidad=0;

        if ($m->origin->active != 1)
        {
            $msg .= '<li>El almacén de origen se encuentra inactivo.</li>';
        }

        if ($m->destination->active != 1)
        {
            $msg .= '<li>El almacén de destino se encuentra inactivo.</li>';
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

        if ($m->origin->activity_id != $m->destination->activity_id)
        {
            $msg .= '<li>Los almacenes de origen y destino son de actividades diferentes</li>';
        }
        if(($m->article->serializable == 1) && ($m->serial == ''))
        {
            $msg .= '<li>Debe incluir el serial del '.$m->article->name.'</li>';
        }
        if(($m->article->active == 0))
        {
            $msg .= '<li>'.$m->article->name.' está marcado como inactivo. Comuníquese con el jefe de almacén.</li>';
        }

//        if(($m->article->serializable==1) AND ($m->serial!='') AND ($m->origin->type_id != 1))
        if(($m->article->serializable==1) AND ($m->serial!=''))
        {
            $lastMovement = $this->lastMovement($m->serial);
            if(!is_null($lastMovement->destination))
            {
                if(($lastMovement->destination_id != $m->origin_id) && ($lastMovement->destination->type_id!=1))
                {
                    $msg .= '<li>El artículo no se encuentra en '. $m->origin->name .'.
                         Verifique el serial del equipo.</li>';
                }
            }
        }

        if ($m->origin->type_id != 1)
        {
            // REVISAR!!! Reemplazar con inventorybasic si no es serializable
            $inventory = collect($m->origin->inventorybasic);
            $filtered = $inventory->filter(function ($item) use($m)
            {
                return $item['id'] == $m->article_id;
            });
            $articulo = $filtered->first(); //dd($m->quantity);
            $cantidad = $articulo['cantidad'];
            if($m->quantity > $articulo['cantidad'] )
            {
                $msg .= '<li>No puede transferir <strong>'.$articulo['cantidad'].'</strong> '.$m->article->name.'</li>';
            }
        }

        return $msg;
    }


    /** Valida el movimiento antes de insertarlo, devuelve un string vacío si no hay errores
     * @param Movement $m
     * @return string
     */
    private function validateSerialMov(Movement $m)
    {
        // Para evitar timeout en validaciones
        set_time_limit(240);
        
        $msg = ''; $cantidad=0;

        if ($m->origin->active != 1)
        {
            $msg .= '<li>El almacén de origen se encuentra inactivo.</li>';
        }

        if ($m->destination->active != 1)
        {
            $msg .= '<li>El almacén de destino se encuentra inactivo.</li>';
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

        if ($m->origin->activity_id != $m->destination->activity_id)
        {
            $msg .= '<li>Los almacenes de origen y destino son de actividades diferentes</li>';
        }
        if(($m->article->serializable == 1) && ($m->serial == ''))
        {
            $msg .= '<li>Debe incluir el serial del '.$m->article->name.'</li>';
        }
        if(($m->article->active == 0))
        {
            $msg .= '<li>'.$m->article->name.' está marcado como inactivo. Comuníquese con el jefe de almacén.</li>';
        }

//        if(($m->article->serializable==1) AND ($m->serial!='') AND ($m->origin->type_id != 1))
        if(($m->article->serializable==1) AND ($m->serial!=''))
        {
            $lastMovement = $this->lastMovement($m->serial);
            if(!is_null($lastMovement->destination))
            {
                if(($lastMovement->destination_id != $m->origin_id) && ($lastMovement->destination->type_id!=1))
                {
                    $msg .= '<li>El artículo no se encuentra en '. $m->origin->name .'.
                         Verifique el serial del equipo.</li>';
                }
            }
        }

        if ($m->origin->type_id != 1)
        {
            $inventory = collect($m->origin->inventoryserial);
            $filtered = $inventory->filter(function ($item) use($m)
            {
                return $item['id'] == $m->article_id;
            });
            $articulo = $filtered->first(); //dd($m->quantity);
            $cantidad = $articulo['cantidad'];
            if($m->quantity > $articulo['cantidad'] )
            {
                $msg .= '<li>No puede transferir <strong>'.$articulo['cantidad'].'</strong> '.$m->article->name.'</li>';
            }
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

    public function porseriales(Request $request)
    {
        if (Auth::user()->securityLevel > 20)
        {

        $seriales = $request->serial;
        $origin_id = $request->id;
        $destination_id = $request->destination_id;
        $origin_id = $request->origin_id;
        $article_id = $request->article_id;
        $ticket = $request->ticket;
        $note = $request->note;
        $remito = $request->remito;
        $user_id = Auth::user()->id;

        $i=0;
        foreach ($seriales as $serial)
        {
            //$i++;
            //$temp = $serial;
            
            $mov = new Movement(
               [
                   'remito' => $remito,
                   'article_id' => $article_id,
                   'quantity' => 1,
                   'note' => $note,
                   'origin_id' => $origin_id,
                   'destination_id' => $destination_id,
                   'ticket' => $ticket,
                   'serial' => $serial,
                   'status_id' => 1,
                   'user_id' => Auth::user()->id
               ]
           );
            
            Movement::create($mov->toArray());
            
        }
        
        
        
        }
        
        return view('movements.porseriales', compact('seriales', 'origin_id', 'destination_id', 'article_id', 'ticket', 'note', 'remito', 'user_id', 'i', 'temp'));
    }

}


