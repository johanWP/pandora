@extends('master')

@section('title')
    Detalle del ticket {{ $vtticket->order_number }}
@endsection

@section('content')
<h1>{{ $vtticket->order_number }}</h1>
<hr/>
<div class="row">
  <div class="table">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Número de orden</th>
            <td>{{ $vtticket->order_number }}</td>
         </tr>
         <tr>
            <th>Tipo de orden</th>
            <td>{{ $vtticket->order_type }}</td>
         </tr>
         <tr>
            <th>Subtipo de orden</th>
            <td>{{ $vtticket->order_subtype }}</td>
         </tr>
         <tr>
            <th>Fecha</th>
            <td>{{ $vtticket->date }}</td>
         </tr>
         <tr>
            <th>Status</th>
            <td>{{ $vtticket->status }}</td>
         </tr>
         <tr>
            <th>Hora de inicio / fin</th>
            <td>{{ $vtticket->time_startend }}</td>
         </tr>
         <tr>
            <th>Notas</th>
            <td>{{ $vtticket->notes }}</td>
         </tr>
         <tr>
            <th>Comentarios de la orden</th>
            <td>{{ $vtticket->order_coments }}</td>
         </tr>
         <tr>
            <th>Comentarios de despacho</th>
            <td>{{ $vtticket->dispatch_coments }}</td>
         </tr>
         <tr>
            <th>Motivo de cancelación</th>
            <td>{{ $vtticket->reason_cancellation }}</td>
         </tr>
         <tr>
            <th>Notas de cierre</th>
            <td>{{ $vtticket->notes_close }}</td>
         </tr>
         <tr>
            <th>Motivo de cierre</th>
            <td>{{ $vtticket->reason_close }}</td>
         </tr>
         <tr>
            <th>Motivo de no realización</th>
            <td>{{ $vtticket->reason_notdone }}</td>
         </tr>
         <tr>
            <th>Motivo suspensión</th>
            <td>{{ $vtticket->reason_suspended }}</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>


<?php
// ajuste de string de busqueda para google maps
$string = $vtticket->address;
$googlemaps = $vtticket->address;
$count = strlen($string);
$done=0;
$i = 0;
while( $i < $count ) {
	if( ctype_digit($string[$i]) ) {
    // primer numero!
 
    while( $i < $count ) {
      if( $string[$i]==' ' ) {
        // primer espacio despues del numero!
        $done++;
        if ($done == 1) $googlemaps = substr($string,0,$i);
      }
      $i++;
    }
	}
	$i++;
}
?>


<h1>Datos del cliente</h1>
<hr/>
<div class="row">
  <div class="table">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Nombre del cliente</th>
            <td>{{ $vtticket->name }}</td>
         </tr>
         <tr>
            <th>Dirección del cliente</th>
            <td>{{ $vtticket->address }}<br /><a href="http://maps.google.com/?q={{ $googlemaps }}" target="_new"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Ver mapa</a></td>
         </tr>
         <tr>
            <th>Nodo</th>
            <td>{{ $vtticket->node }}</td>
         </tr>
         <tr>
            <th>Ciudad</th>
            <td>{{ $vtticket->city }}</td>
         </tr>
         <tr>
            <th>Región</th>
            <td>{{ $vtticket->region }}</td>
         </tr>
         <tr>
            <th>Teléfono</th>
            <td>{{ $vtticket->phone }}</td>
         </tr>
         <tr>
            <th>Número de cliente</th>
            <td>{{ $vtticket->customer_id }}</td>
         </tr>
         <tr>
            <th>Habilidades de trabajo</th>
            <td>{{ $vtticket->work }}</td>
         </tr>
         <tr>
            <th>Zona</th>
            <td>{{ $vtticket->zone }}</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>



<!-- Movimientos de materiales para ticket padre -->
<h1>Movimientos de materiales</h1>
<hr/>
@if($movements->count() > 0)

<div class="row">
  <div class="table">  
                <table class="table table-striped"">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Cant.</th>
                        <th>Artículo</th>
                        <th>Desde</th>
                        <th><b> &nbsp;</b></th>
                        <th>Hacia</th>
                        <th class="text-center" colspan="2">Acciones</th>

                    </tr>
                    </thead>
                    <tbody>
                    
                @foreach($movements as $movement)

                    <tr class="{{ $movement->id }}">
                        <td>
                            <p class="text-center">

                                @if ($movement->status_id == '1')
                                    <i class="fa fa-check"></i>
                                @elseif($movement->status_id == '2')
                                    <i class="fa fa-question"></i>
                                @elseif($movement->status_id == '3')
                                    <i class="fa fa-trash"></i>
                                @elseif($movement->status_id == '4')
                                    <i class="fa fa-close"></i>
                                @endif
                            </p>
                        </td>
                        <td>
                            <p class="text-left">
                                {{ $movement->quantity}}
                            </p>
                        </td>
                        <td>
                            <p class="text-left">
                                {{ $movement->article->name}}
                            </p>
                        </td>
                        <td>
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
                            <a href="/movimientos/{{ $movement->id }}" id="btnVer" class="btn btn-default">
                                <i class="fa fa-eye fa-2x"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                      </tbody>
                </table>
  </div></div>
@else
	No hay movimientos de materiales para este ticket
@endif  


<!-- Tickets  reincidentes T-180 dias -->
<h1>Historial de visitas</h1>
<hr/>
@if($reincidentes->count() > 0)
	Cantidad de visitas completadas en los últimos 180 días: {{ $reincidentes->count() }}

	@foreach($reincidentes as $reincidente)

	
<div class="row">
  <div class="table">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Fecha</th>
            <td>{{ $reincidente->date }}</td>
         </tr>
         <tr>
            <th>Notas de cierre</th>
            <td>{{ $reincidente->notes_close }}</td>
         </tr>
         <tr>
            <th>Motivos de cierre</th>
            <td>{{ $reincidente->reason_close }}</td>
         </tr>
         <!--
		 <tr>
            <th>Debug</th>
            <td>Cliente: {{ $reincidente->customer_id }} / Status: {{ $reincidente->status }}</td>
         </tr>
		 -->
      </tbody>
    </table>
  </div>
</div>
<a href="/vttickets/{{ $reincidente->id }}">Ver detalles de visita {{ $reincidente->order_number }}</a>
		 <hr />
	@endforeach
@else
	No hay VTs reincidentes
@endif


@endsection