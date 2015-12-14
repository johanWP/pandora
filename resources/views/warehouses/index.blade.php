@extends('master')

@section('title')
    Almacenes Registrados
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Almacenes Registrados</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-primary" href="{{ action('WarehousesController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">

    @include('search.autocomplete')

</div>
@if($warehouses->count() > 0)
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th><h3>Estatus</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($warehouses as $warehouse)
                <tr>
                  <td class="col-sm-9">
                    <p class="text-left">
                      <a href="{{ action('WarehousesController@show', $warehouse->id) }}">{{ $warehouse->name }}</a>
                    </p>
                  </td>
                  <td class="col-sm-9">
                    <p class="text-left">
                      @if ($warehouse->active == 0)
                          Inactivo
                      @else
                          Activo
                      @endif
                    </p>
                  </td>
                  <td class="text-right">
                    <a href="{{ action('WarehousesController@edit', $warehouse->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="#modalConfirm" id="btnDelete" class="btn btn-danger" data-toggle="modal" data-name="{{ $warehouse->name}}" data-deleteMe="{{ $warehouse->id }}">
                      <i class="fa fa-trash fa-fw"></i> Eliminar
                    </a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>

</div>

<div class="row">
    <div class="text-center">{!! $warehouses->render() !!}</div>
</div>
@else
	<h2>No hay almacenes cargados en el sistema.</h2>
@endif
@endsection


@section('scripts')

  @include('partials.modalConfirm')
  <script src="/js/jquery-ui.min.js"></script>

  <script>
$(function()
  {
      $( "#q" ).autocomplete(
      {
          source: "search/autocomplete/warehouses",
          minLength: 3,
          select: function(event, ui)
          {
              $('#q').val(ui.item.value);
              $('#btnDetalle').attr('href','/almacenes/'+ ui.item.id)
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