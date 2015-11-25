<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomUserRequest;
use App\Http\Requests\CustomUpdateUserRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Redirect;
use App\Activity;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::orderBy('firstName', 'asc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activities = Activity::lists('name', 'id');
        return view('users.create', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomUserRequest $request)
    {
//        dd($request['active']);
        if (is_null($request['active']))
        {
            $act = 0;
        } else {
            $act = $request['active'];
        }

//        Si el que hace el insert es un superusuario, puede setear la empresa del usuario creado
//    a través de la interface
        if (Auth::user()->securityLevel == 100)
        {
            $company_id = $request['company_id'];
        } else
        {
            $company_id = Auth::user()->company_id;
        }

        $user = User::create([
                'username'  => $request['username'],
                'firstName' => $request['firstName'],
                'lastName'  => $request['lastName'],
                'email'     => $request['email'],
                'securityLevel'  => $request['securityLevel'],
                'company_id'=> $company_id,
                'password'  => bcrypt($request['password']),
                'active'    => $act
            ]);

//        Asociar las actividades en la tabla pivot activities_users
        $user->activities()->attach($request->input('activityList'));


        session()->flash('flash_message', 'Usuario creado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('usuarios');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.ver', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $activities = Activity::lists('name', 'id');
        return view('users.edit', compact('user', 'activities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomUpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (is_null($request['active']))
        {
            $act = 0;
        } else {
            $act = $request['active'];
        }
//        Si el que hace el update es un superusuario, puede setear la empresa del usuario creado
//    a través de la interface
        if (Auth::user()->securityLevel == 100)
        {
            $company_id = $request['company_id'];
        } else
        {
            $company_id = Auth::user()->company_id;
        }

        $user->update([
            'firstName'     => $request['firstName'],
            'lastName'      => $request['lastName'],
            'email'         => $request['email'],
            'securityLevel'         => $request['securityLevel'],
            'company_id'    => $company_id,
            'active'        => $act
        ]);

//        Asociar las actividades en la tabla pivot activities_users
        if ($request->input('activityList') != null)
        {
            $user->activities()->sync($request->input('activityList'));
        } else
        {
            $user->activities()->detach();
        }


        session()->flash('flash_message', 'Usuario actualizado correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);

        return Redirect::to('usuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('flash_message_danger', 'Usuario borrado correctamente.');

//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('usuarios');
    }
}
