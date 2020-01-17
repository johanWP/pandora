<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Response;
use Redirect;
use App\Article;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\HttpResponse;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::orderBy('name', 'asc')->paginate(20);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $article = new Article($request->all());
        Article::create($article->toArray());

        session()->flash('flash_message', 'Artículo creado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('articulos');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.ver', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param int $id
     * @return Response
     */
    public function update($id, ArticleRequest $request)
    {
//        dd($request->all());
        if ($request->active == 1) {
            $act = 1;
        } else {
            $act = 0;
        }
        if ($request->fav == 1) {
            $fav = 1;
        } else {
            $fav = 0;
        }
        if ($request->serializable == 1) {
            $serializable = 1;
        } else {
            $serializable = 0;
        }
        $article = Article::findOrFail($id);
        $article->update([
            'name' => $request->name,
            'barcode' => $request->barcode,
            'product_code' => $request->product_code,
            'serializable' => $serializable,
            'active' => $act,
            'fav' => $fav
        ]);

        session()->flash('flash_message', 'El artículo se actualizó.');
        return redirect('articulos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        session()->flash('flash_message_danger', 'Artículo borrado correctamente.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return redirect('articulos');
    }
}
