@extends('master')

@section('title')
    Actividades Registradas
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Actividades Registradas</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-success" href="{{ action('ActivitiesController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nueva</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
@if($activities->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($activities as $activity)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left">
                      <a href="{{ action('ActivitiesController@edit', $activity->id) }}">{{ $activity->name }}</a>
                    </p>
                  </td>
                  <td class="text-right">
                    <a href="{{ action('ActivitiesController@edit', $activity->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="#modalConfirm" id="btnDelete" class="btn btn-danger" data-toggle="modal" data-name="{{ $activity->name }}" data-deleteMe="{{ $activity->id }}">
                      <i class="fa fa-trash fa-fw"></i> Eliminar
                    </a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>








@else
	<h2>No hay Actividades cargadas en el sistema.</h2>
@endif
@endsection

@section('scripts')

  @include('partials.modalConfirm')

@endsection