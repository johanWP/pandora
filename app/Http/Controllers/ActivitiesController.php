<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Response;
use Redirect;
use App\Activity;
use App\Http\Requests;
use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\HttpResponse;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $activities = Activity::all();
        return view('activities.index', compact('activities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('activities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ActivityRequest $request
     * @return Response
     */
    public function store(ActivityRequest $request)
    {
        Activity::create($request->all());
        session()->flash('flash_message', 'Actividad creada correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);
        return Redirect::to('actividades');
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
        $activity = Activity::findOrFail($id);
        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ActivityRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, ActivityRequest $request)
    {
        $activity = Activity::findOrFail($id);
        $activity->update($request->all());
        session()->flash('flash_message', 'Actividad actualizada correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);

        return Redirect::to('actividades');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        session()->flash('flash_message_danger', 'Actividad borrada correctamente.');
//        Si flash_message_important esta presente, el mensaje no desaparece hasta que el usuario lo cierre
//        session()->flash('flash_message_important', true);

        return Redirect::to('actividades');
    }

}
