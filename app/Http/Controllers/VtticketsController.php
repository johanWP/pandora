<?php

namespace App\Http\Controllers;

use Auth;
use Redirect;
use App\Vtticket;
use App\Movement;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\HttpResponse;

class VtticketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vttickets = Vtticket::orderBy('date', 'dsc')->paginate(30);
        return view('vttickets.index', compact('vttickets'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vtticket = Vtticket::findOrFail($id);
		
		// Busco los reincidentes
		//$fecha = $vtticket['date'];
		//$fecha->subDays(180);
		//$fecha->sub(new DateInterval('P180D'));
		$reincidentes = Vtticket::where('customer_id', $vtticket['customer_id'])->whereNotIn('id', [$vtticket['id']])->where('status','Completado')->whereNotBetween('date',[$vtticket['date'],'2100-01-01'])->orderBy('date', 'dsc')->get();

		// Busco los movimientos para ese ticket
		// !!! Está copiado de ReportsController !!!
		$movements = Movement::where('ticket', $vtticket['order_number'])->
					whereIn('status_id', [1,2,4])->
					orderBy('id', 'desc')->
					get();
		
        return view('vttickets.ver', compact('vtticket','reincidentes','movements'));
    }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agenda()
    {
		$fecha = date("Y-m-d");
		//$fecha = '2016-04-14';		
		$tempdate = strtotime('-180 days');
		$fecha_garantia = date('Y-m-d', $tempdate);
		
		$i=0;
		$conreincidentes=0;
		$conreincidentesnorte=0;
		$conreincidentessur=0;
		$ticketsnorte=0;
		$ticketssur=0;
		
		
		$vttickets = Vtticket::where('date', $fecha)->orderBy('region', 'asc')->orderBy('node', 'asc')->get();
		
		foreach ($vttickets as $vtticket)
            {
				$conteo = Vtticket::where('customer_id', $vtticket['customer_id'])->whereNotIn('id', [$vtticket['id']])->where('date', '>', $fecha_garantia)->where('status','Completado')->count();
				$reincidentes->id[$i] = $vtticket->id;
				$reincidentes->region[$i] = $vtticket->region;
				$reincidentes->node[$i] = $vtticket->node;
				$reincidentes->notes[$i] = $vtticket->notes;
				$reincidentes->ticket[$i] = $vtticket->order_number;
				$reincidentes->reincidentes[$i] = $conteo;
				if ($conteo>0) $conreincidentes ++;
				
				if ($vtticket->region=="NORTE") {
					if ($conteo>0) $conreincidentesnorte++;
					$ticketsnorte++;
				}
				if ($vtticket->region=="SUR") {
					if ($conteo>0) $conreincidentessur++;
					$ticketssur++;
				}
				$i++;
			}
		
        return view('vttickets.agenda', compact('reincidentes','i','conreincidentes','conreincidentesnorte','conreincidentessur','ticketsnorte','ticketssur','fecha_garantia'));
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
        $vtticket = Vtticket::findOrFail($id);
        return view('vttickets.edit', compact('vtticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, VtticketRequest $request)
    {
//        dd($request->all());
        if ($request->active==1)
        {
            $act = 1;
        } else {
            $act = 0;
        }
        if ($request->fav==1)
        {
            $fav = 1;
        } else {
            $fav = 0;
        }
        if ($request->serializable==1)
        {
            $serializable = 1;
        } else {
            $serializable = 0;
        }
        $vtticket = Vtticket::findOrFail($id);
        $vtticket->update([
                'name'  => $request->name,
                'barcode'  => $request->barcode,
                'product_code'  => $request->product_code,
                'serializable'  => $serializable,
                'active'  => $act,
                'fav'  => $fav
        ]);

        session()->flash('flash_message', 'El artículo se actualizó.');
        return redirect('vttickets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Vtticket = Vtticket::findOrFail($id);
        $Vtticket->delete();
        session()->flash('flash_message_danger', 'Artículo borrado correctamente.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return redirect('vttickets');
    }
}
