@extends('master')

@section('title')
    Usuarios Registrados
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Usuarios Registrados</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-success" href="{{ action('UsersController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
<div class="row">
@if($users->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th><h3>Usuario</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left">
                      <a href="{{ action('UsersController@edit', $user->id) }}">{{ $user->firstName . " ". $user->lastName }}</a>
                    </p>
                  </td>
                  <td>
                    <p class="text-left">
                      <a href="{{ action('UsersController@edit', $user->id) }}">{{ $user->username }}</a>
                    </p>
                  </td>
                  <td class="text-right">
                    <a href="{{ action('UsersController@edit', $user->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="{{ action('UsersController@edit') }}" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Eliminar</a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="row">
    <div class="text-center">{!! $users->render() !!}</div>
</div>
@else
	<h2>No hay Usuarios cargados en el sistema.</h2>
@endif
@endsection
