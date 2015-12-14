@extends('master')

@section('title')
    Últimos Movimientos
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Últimos Movimientos</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-primary" href="{{ action('MovementsController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
<div class="row">
@if($movements->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th>Status</th>
			  <th>Cant.</th>
			  <th>Artículo</th>
			  <th><h3>Desde</h3></th>
			  <th><b> &nbsp;</b></th>
			  <th><h3>Hacia</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($movements as $movement)
                <tr>
                  <td class="col-sm-1">
                    <p class="text-left">
{{--
                    Status 1: Aprobado
                    Status 2: Por Aprobar
                    Status 3: Eliminado
--}}
                      @if ($movement->status_id ==1)
                        <p><b>OK</b></p>
                      @elseif ($movement->status_id ==2)
                        <p style="color:red">P</p>
                      @else
                        <p>D</p>
                      @endif

                  </td>
                  <td class="col-sm-1">
                    <p class="text-left">
                      {{ $movement->quantity}}
                    </p>
                  </td>
                  <td class="col-sm-4">
                    <p class="text-left">
                      {{ $movement->article->name}}
                    </p>
                  </td>
                  <td class="col-sm-2">
                    <p class="text-left">
                      <a href="{{ action('MovementsController@show', $movement->id) }}">{{ $movement->origin->name}}</a>
                    </p>
                  </td>
                  <td>
                    <p class="text-center">
                      <span><i class="fa fa-arrow-right fw"></i></span>
                    </p>
                  </td>
                  <td>
                    <p class="text-left">
                      <a href="{{ action('MovementsController@show', $movement->id) }}">{{ $movement->destination->name}}</a>
                    </p>
                  </td>
                  <td class="text-right">
                  @if(Auth::user()->securityLevel >= 20)
                    <a href="#modalApprove" id="btnApprove" class="btn btn-default" data-toggle="modal" data-name="este movimiento" data-approveMe="{{ $movement->id }}">
                      <i class="fa fa-check fa-fw"></i> Aprobar
                    </a>
                  @endif
                  </td>
                  <td>
                  @if(Auth::user()->securityLevel >= 20)
                    <a href="#modalConfirm" id="btnDelete" class="btn btn-danger" data-toggle="modal" data-name="este movimiento" data-deleteMe="{{ $movement->id }}">
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
    <div class="text-center">{!! $movements->render() !!}</div>
</div>
@else
	<h2>No hay movimientos cargados en el sistema.</h2>
@endif
@endsection

@section('scripts')

  @include('partials.modalConfirm')

  @if(Auth::user()->securityLevel > 20)
    @include('partials.modalApprove')
  @endif

@endsection