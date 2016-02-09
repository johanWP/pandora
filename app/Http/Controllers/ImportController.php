<?php

namespace App\Http\Controllers;

use App\Article;
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
}
