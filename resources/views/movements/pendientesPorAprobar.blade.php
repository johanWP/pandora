@extends('master')

@section('title')
    Movimientos Pendientes por Aprobar
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Movimientos Pendientes por Aprobar</h1>
  </div>
</div>

<hr/>

@foreach($warehouses as $warehouse)
	
@endforeach

<?php
    $ticketActual = '~~~~~~~~~';
    $i = 0;
?>
<div class="row">
@if($movements->count() > 0)
	<div class="table-responsive">
		@foreach($movements as $movement)
            @if($ticketActual != $movement->ticket)
                @if ($i > 0)
                    </tbody>
                    </table>

                @endif
<?php
$ticketActual = $movement->ticket;
$i++;
?>
                <h3 class="{{$ticketActual}}">{{$ticketActual}}</h3>
                <table class="table table-striped {{$ticketActual}}" id="table_{{$ticketActual}}">
                    <thead>
                    <tr>
                      <th>Cant.</th>
                      <th>Artículo</th>
                      <th>Desde</th>
                      <th><b> &nbsp;</b></th>
                      <th>Hacia</th>
                      <th class="text-center" colspan="2">Acciones</th>

                    </tr>
                    </thead>
                    <tbody>
            @endif
                <tr class="{{ $movement->id }}">
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
                      {{ $movement->origin->name}}
                    </p>
                  </td>
                  <td>
                    <p class="text-center">
                      <span><i class="fa fa-arrow-right fw"></i></span>
                    </p>
                  </td>
                  <td>
                    <p class="text-left">
                      {{ $movement->destination->name}}
                    </p>
                  </td>
                  <td class="text-center">

                  @if((Auth::user()->securityLevel >= 20) AND ($movement->status_id ==2))
                    <a href="#modalApprove" class="btn btn-primary" data-toggle="modal" data-id="{{ $movement->id }}" data-name="aprobar"  data-ticket="{{$movement->ticket}}" data-note="{{ $movement->note }}">
                      <i class="fa fa-check"></i>
                    </a>
                  @endif

                  <a href="/movimientos/{{ $movement->id }}" id="btnVer" class="btn btn-default">
                      <i class="fa fa-eye"></i>
                  </a>

                  @if(Auth::user()->securityLevel >= 20)
                    <a href="#modalApprove" class="btn btn-danger" data-toggle="modal" data-id="{{ $movement->id }}" data-name="rechazar" data-ticket="{{$movement->ticket}}" data-note="{{ $movement->note }}">
                      <i class="fa fa-close"></i>
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
	<h2><i class="fa fa-smile-o fa-2x"></i> Éxito! No hay movimientos pendientes por aprobar.</h2>
@endif
@endsection

@section('scripts')

  {{--@include('partials.modalConfirm')--}}

  @if(Auth::user()->securityLevel > 20)
    @include('partials.modalApprove')
    {{--@include('partials.modalReject')--}}
  @endif

@endsection