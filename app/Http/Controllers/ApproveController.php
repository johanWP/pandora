<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApproveController extends Controller
{
    public function viewAll()
    {
/*        $movements  = DB::table('movements')
            ->where('status_id', '=', '2')
            ->orderBy('ticket')
            ->get();
*/
        $movements = Movement::query('select * from movements where status_id=2')
                        ->where('status_id', '2')
                        ->orderBy('ticket', 'asc')->paginate(20);

//        dd($movements);
        return view('movements.pendientesPorAprobar', compact('movements'));
    }

    public function approveMovement(Request $request)
    {
//        dd($request->id);
        if(Auth::user()->securityLevel >= 20)
        {
            $m = Movement::findOrFail($request->id);
            $result = $m->update([
                'status_id' => '1',
                'approved_by' => Auth::user()->id
            ]);
        }
        return $request->id;

    }
}
