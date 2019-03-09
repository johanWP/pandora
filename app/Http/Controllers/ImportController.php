<?php

namespace App\Http\Controllers;

use App\Article;
use App\Vtticket;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
class ImportController extends Controller
{
    public function importArticles(Request $request)
    {
        $myfile = Input::file('myfile');
//
        $name = Carbon::now()->secondsUntilEndOfDay().'_'.$myfile->getClientOriginalName();
        $result = Storage::disk('local')->put($name, File::get($myfile));

        if ($result) {
            $i = $this->insertArticles($name);
            session()->flash('flash_message', 'Se importaron correctamente los artículos nuevos.');
        } else {
            session()->flash('flash_message_danger', 'Ha ocurrido un error. Intentelo de nuevo más tarde o reporte el error.');
        }

        session()->flash('flash_message_important', true);
        return Redirect::to('articulos/import');
    }

    public function articles()
    {
        return view('articles.import');
    }

    private function insertArticles($filename)
    {
        $i=0;
        $filename = 'storage/app/'.$filename;
        Excel::load($filename, function($reader)  use ($i)
        {
            $results = $reader->get();
            foreach ($results as $article)
            {
                $NoEstaEnLaBD = is_null(
                                Article::where('product_code',$article['codigo'])->
                                first());

                if ($NoEstaEnLaBD)
                { // si el articulo _NO_ se encuentra en la base de datos
                    if (is_null($article['serializable'])) {
                        $serializable = 0;
                    } else {
                        $serializable = $article['serializable'];
                    }
                    $a = Article::create(
                        [
                            'product_code' => $article['codigo'],
                            'unit' => $article['ub'],
                            'name' => $article['descripcion'],
                            'barcode' => $article['barcode'],
                            'fav' => $article['fav'],
                            'serializable' => $serializable,
                            'active' => $article['activo']
                        ]
                    );
                    $i++;
                } else
                {   // si el codigo se encuentra en la base de datos

                }

            }

        });  // Fin del Excel::load
        return $i;
    }
	
	//////////////////////////////////////////////
	// IMPORTACION TICKETS DE VT
    public function importvttickets(Request $request)
    {
        $myfile = Input::file('myfile');
		
        $name = Carbon::now()->secondsUntilEndOfDay().'_'.$myfile->getClientOriginalName();
        $result = Storage::disk('local')->put($name, File::get($myfile));

        if ($result) {
            $i = $this->insertvttickets($name);
            session()->flash('flash_message', 'Se importaron correctamente los tickets nuevos.');
        } else {
            session()->flash('flash_message_danger', 'Ha ocurrido un error. Intentelo de nuevo más tarde o reporte el error.');
        }

        session()->flash('flash_message_important', true);
        return Redirect::to('vttickets/import');
    }

    public function vttickets()
    {
        return view('vttickets.import');
    }

    private function insertvttickets($filename)
    {
        $i=0;
        $filename = 'storage/app/'.$filename;
        Excel::load($filename, function($reader)  use ($i)
        {

            $results = $reader->get();
			
			// borro lo que está en el excel de la DB, pero de la misma fecha solamente
			foreach ($results as $ticket) {
				$deletedRows = Vtticket::where('order_number', $ticket['order_number'])->where('date',$ticket['date'])->delete();
			}
			
			// agrego
			reset($results);
            foreach ($results as $ticket)
            {
                if($ticket['order_number']) {
                    $a = Vtticket::create(
                        [
							
						'order_number' => $ticket['order_number'],
						'order_type' => $ticket['order_type'],
						'order_subtype' => $ticket['order_subtype'],
						'date' => $ticket['date'],
						'status' => $ticket['status'],
						'name' => $ticket['name'],
						'address' => $ticket['address'],
						'location' => $ticket['location'],
						'node' => $ticket['node'],
						'city' => $ticket['city'],
						'region' => $ticket['region'],
						'postalcode' => $ticket['postalcode'],
						'phone' => $ticket['phone'],
						'cellular' => $ticket['cellular'],
						'email' => $ticket['email'],
						'timeframe' => $ticket['timeframe'],
						'service_window' => $ticket['service_window'],
						'window' => $ticket['window'],
						'time_start' => $ticket['time_start'],
						'time_end' => $ticket['time_end'],
						'time_startend' => $ticket['time_startend'],
						'sla_start' => $ticket['sla_start'],
						'sla_end' => $ticket['sla_end'],
						'duration' => $ticket['duration'],
						'traveling_time' => $ticket['traveling_time'],
						'activity_type' => $ticket['activity_type'],
						'activity_notes' => $ticket['activity_notes'],
						'customer_id' => $ticket['customer_id'],
						'services' => $ticket['services'],
						'cod' => $ticket['cod'],
						'notes' => $ticket['notes'],
						'order_coments' => $ticket['order_coments'],
						'dispatch_coments' => $ticket['dispatch_coments'],
						'reason_cancellation' => $ticket['reason_cancellation'],
						'notes_close' => $ticket['notes_close'],
						'work' => $ticket['work'],
						'zone' => $ticket['zone'],
						'reason_close' => $ticket['reason_close'],
						'reason_notdone' => $ticket['reason_notdone'],
						'reason_suspended' => $ticket['reason_suspended']

                        ]
					);
				}
				/*
				$NoEstaEnLaBD = is_null(
                                Vtticket::where('order_number',$ticket['order_number'])->
                                first());

                if ($NoEstaEnLaBD)
                { // si el articulo _NO_ se encuentra en la base de datos

                    $a = Vtticket::create(
                        [
							
						'order_number' => $ticket['order_number'],
						'order_type' => $ticket['order_type'],
						'order_subtype' => $ticket['order_subtype'],
						'date' => $ticket['date'],
						'status' => $ticket['status'],
						'name' => $ticket['name'],
						'address' => $ticket['address'],
						'location' => $ticket['location'],
						'node' => $ticket['node'],
						'city' => $ticket['city'],
						'region' => $ticket['region'],
						'postalcode' => $ticket['postalcode'],
						'phone' => $ticket['phone'],
						'cellular' => $ticket['cellular'],
						'email' => $ticket['email'],
						'timeframe' => $ticket['timeframe'],
						'service_window' => $ticket['service_window'],
						'window' => $ticket['window'],
						'time_start' => $ticket['time_start'],
						'time_end' => $ticket['time_end'],
						'time_startend' => $ticket['time_startend'],
						'sla_start' => $ticket['sla_start'],
						'sla_end' => $ticket['sla_end'],
						'duration' => $ticket['duration'],
						'traveling_time' => $ticket['traveling_time'],
						'activity_type' => $ticket['activity_type'],
						'activity_notes' => $ticket['activity_notes'],
						'customer_id' => $ticket['customer_id'],
						'services' => $ticket['services'],
						'cod' => $ticket['cod'],
						'notes' => $ticket['notes'],
						'order_coments' => $ticket['order_coments'],
						'dispatch_coments' => $ticket['dispatch_coments'],
						'reason_cancellation' => $ticket['reason_cancellation'],
						'notes_close' => $ticket['notes_close'],
						'work' => $ticket['work'],
						'zone' => $ticket['zone'],
						'reason_close' => $ticket['reason_close'],
						'reason_notdone' => $ticket['reason_notdone'],
						'reason_suspended' => $ticket['reason_suspended']

                        ]
                    );
                    $i++;
                } else
                {   // si el codigo se encuentra en la base de datos, actualizo
					$updticket = Vtticket::findOrFail($id);
					$updticket->update([
						'order_number' => $ticket['order_number'],
						'order_type' => $ticket['order_type'],
						'order_subtype' => $ticket['order_subtype'],
						'date' => $ticket['date'],
						'status' => $ticket['status'],
						'name' => $ticket['name'],
						'address' => $ticket['address'],
						'location' => $ticket['location'],
						'node' => $ticket['node'],
						'city' => $ticket['city'],
						'region' => $ticket['region'],
						'postalcode' => $ticket['postalcode'],
						'phone' => $ticket['phone'],
						'cellular' => $ticket['cellular'],
						'email' => $ticket['email'],
						'timeframe' => $ticket['timeframe'],
						'service_window' => $ticket['service_window'],
						'window' => $ticket['window'],
						'time_start' => $ticket['time_start'],
						'time_end' => $ticket['time_end'],
						'time_startend' => $ticket['time_startend'],
						'sla_start' => $ticket['sla_start'],
						'sla_end' => $ticket['sla_end'],
						'duration' => $ticket['duration'],
						'traveling_time' => $ticket['traveling_time'],
						'activity_type' => $ticket['activity_type'],
						'activity_notes' => $ticket['activity_notes'],
						'customer_id' => $ticket['customer_id'],
						'services' => $ticket['services'],
						'cod' => $ticket['cod'],
						'notes' => $ticket['notes'],
						'order_coments' => $ticket['order_coments'],
						'dispatch_coments' => $ticket['dispatch_coments'],
						'reason_cancellation' => $ticket['reason_cancellation'],
						'notes_close' => $ticket['notes_close'],
						'work' => $ticket['work'],
						'zone' => $ticket['zone'],
						'reason_close' => $ticket['reason_close'],
						'reason_notdone' => $ticket['reason_notdone'],
						'reason_suspended' => $ticket['reason_suspended']
					]);			
					
                }
			*/
            }

        });  // Fin del Excel::load
        return $i;
    }
}
