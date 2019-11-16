<?php

namespace App\Http\Controllers;

use App\Movement;
// agregado para viewAll por empresa
use App\Warehouse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ApproveController extends Controller
{
    public function viewAll()
    {

// armo un arreglo para solo traer los warehouses de la misma empresa que el usuario
        $warehouses = Warehouse::where('company_id', Auth::user()->current_company_id)
            //->where('type_id', '<>', 1)
            ->orderBy('name', 'asc')
            ->get();

        foreach ($warehouses as $warehouse)
        {
            $mywarehouses[] = $warehouse->id;
        }

/*        $movements  = DB::table('movements')
            ->where('status_id', '=', '2')
            ->orderBy('ticket')
            ->get();

        $movements = Movement::query('select * from movements where status_id=2')
                        ->where('status_id', '2')
                        ->orderBy('ticket', 'asc')->paginate(20);

*/

        $movements = Movement::query('select * from movements where status_id=2')
                        ->where('status_id', '2')
                        ->whereIn('origin_id', $mywarehouses)
                        ->whereIn('destination_id', $mywarehouses)
                        ->orderBy('ticket', 'asc')->paginate(20);

//        dd($movements);

           
        return view('movements.pendientesPorAprobar', compact('movements','warehouses'));
    }

    public function approveMovement(Request $request)
    {
//        dd($request->id);
        if(Auth::user()->securityLevel >= 20)
        {
            $m = Movement::findOrFail($request->id);
            $result = $m->update([
                'status_id' => '1',
                'approved_by' => Auth::user()->id,
                'note'  => $request->note
            ]);
        }
        return $request->id;

    }

    public function rejectMovement(Request $request)
    {
        if(Auth::user()->securityLevel >= 20)
        {
            $m = Movement::findOrFail($request->id);
            $m->update([
                'status_id' => '4',
                'approved_by' => Auth::user()->id,
                'note'  => $request->note
            ]);

            $arrayM = [
                        'article' => $m->article->name,
                        'origen'  => $m->origin->name,
                        'destino' => $m->destination->name,
                        'created_at'=> $m->created_at,
                        'ticket'  => $m->ticket,
                        'cantidad'=> $m->quantity,
                        'nota'    => $m->note
                    ];

            $result = Mail::send('emails.movementRejected',$arrayM, function($message) use ($m) {
//                $message->from($request->email);
                $message->to($m->user->email)
                    ->subject('Tu movimiento ha sido rechazado')
                    ->replyTo(Auth::user()->email);
            });

        }
        return $request->id;
    }
}
