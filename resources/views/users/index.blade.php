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
    <a class="btn btn-primary" href="{{ action('UsersController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">

    @include('search.autocomplete')

</div>
<div class="row">
@if($users->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th><h3>Usuario</h3></th>
			  <th><h3>Estatus</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
                <tr>
                  <td class="col-sm-9">
                    <p class="text-left">
                      <a href="{{ action('UsersController@show', $user->id) }}">{{ $user->firstName . " ". $user->lastName }}</a>
                    </p>
                  </td>
                  <td>
                    <p class="text-left">
                      <a href="{{ action('UsersController@show', $user->id) }}">{{ $user->username }}</a>
                    </p>
                  </td>
                  <td>
                    <p class="text-left">
                      @if ($user->active == 0)
                          Inactivo
                      @else
                          Activo
                      @endif
                    </p>
                  </td>
                  <td class="text-right">
                  @if (Auth::user()->securityLevel >= 40)
                    <a href="{{ action('UsersController@edit', $user->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  @endif
                  </td>
                  <td>
                  @if (Auth::user()->securityLevel >= 40)
                    <a href="#modalConfirm" id="btnDelete" class="btn btn-danger" data-toggle="modal" data-name="{{ $user->firstName . " ".$user->lastName}}" data-deleteMe="{{ $user->id }}">
                      <i class="fa fa-trash fa-fw"></i> Eliminar
                    </a>
                  @endif
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

@section('scripts')

  @include('partials.modalConfirm')
  <script src="/js/jquery-ui.min.js"></script>
  <script src="/js/functions.js"></script>
  <script>
$(function()
  {
      $( "#q" ).autocomplete(
      {
          source: "search/autocomplete/users",
          minLength: 3,
          select: function(event, ui)
          {
              $('#q').val(ui.item.value);
              $('#btnDetalle').attr('href','/usuarios/'+ ui.item.id)
                              .attr('disabled', false);
          }  // fin del select
      });     // fin del $( "#q" ).autocomplete
  });   // fin del document.ready

  </script>
@endsection

@section('css')
  <link rel="stylesheet" href="/css/jquery-ui.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.structure.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.theme.min.css">

@endsection