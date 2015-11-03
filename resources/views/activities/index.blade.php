@extends('master')

@section('title')
    Listado de Actividades
@endsection

@section('content')
    <h1>Listado de Actividades</h1>
    <hr/>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
      @foreach($activities as $activity)
        <tr>
          <td><p>{{ $activity->name }}</p></td>
          <td>
            <a class="btn btn-primary" href="{{action('ActivitiesController@edit', $activity->id)}}">Editar</a>
            <a class="btn btn-danger">Eliminar</a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
@endsection