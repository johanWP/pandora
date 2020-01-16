<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Requests\CustomAuthRequest;
use App\Http\Controllers\Controller;

class CustomAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return view('auth.login2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Verifica las credenciales de login y redirige apropiadamente
     *
     * @param  \Illuminate\Http\Requests\CustomAuthRequest  $request
     * @return Response
     */
    public function store(CustomAuthRequest $request)
    {
//        dd($request->rememberMe);
        $remember = $request->rememberMe;
//        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => 1]))
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember))
        {
//  Si el usuario existe pero esta inactivo, la sesión se crea igual.  1) la destruyo 2) muestro mensaje
            if (Auth::user()->active == 0)
            {
                Auth::logout();
                return view('pages.inactive');
            }

//            Si el usuario tiene credenciales y está activo, muestro su escritorio
            return Redirect::to('escritorio');
        }
        session()->flash('flash_message_danger', 'Nombre de usuario y/o contraseña no válidos.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
        session()->flash('flash_message_important', true);
        return Redirect::to('/login');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
