@extends('master')

@section('title')
    VT Tickets Registrados
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Agenda de Tickets VT para el <?PHP echo date("d/m"); ?></h1>
  </div>
</div>
<hr/>


@if($reincidentes)

<?PHP
$norteporc = round(100*$conreincidentesnorte/$ticketsnorte, 2);
$surporc = round(100*$conreincidentessur/$ticketssur, 2);
?>

<p>NORTE: {{ $conreincidentesnorte }} reincidentes / {{ $ticketsnorte }} tickets <span class="label label-danger">{{ $norteporc }}%</span></p>
<p>SUR: {{ $conreincidentessur }} reincidentes / {{ $ticketssur }} tickets <span class="label label-danger">{{ $surporc }}%</span></p>
<p>FECHA DE GARANTIA: {{ $fecha_garantia }}</span></p>
	
<div class="row">
	<div class="table-responsive">
		<table class="table">
			<thead>
			<tr>
			  <th><h3>Region</h3></th>
				<th><h3>Node</h3></th>
				<th><h3>Ticket</h3></th>
				<th><h3>Notas</h3></th>
			  <th><h3>Reincidentes</h3></th>
			</tr>
			</thead>
			<tbody>

@for ($a = 0; $a < $i; $a++)
                @if ($reincidentes->reincidentes[$a]>2)
				  <tr class="danger">
				@elseif ($reincidentes->reincidentes[$a]>0)
				  <tr class="warning">
				@else
				  <tr>
				@endif
                   <td>
                    {{ $reincidentes->region[$a] }}
                  </td>
                   <td>
                    {{ $reincidentes->node[$a] }}
                  </td>

				  <td>
                    <p class="text-left">
                      <a href="/vttickets/{{ $reincidentes->id[$a] }}">{{ $reincidentes->ticket[$a] }}</a>
                    </p>
                  </td>
                   <td>
                    {{ $reincidentes->notes[$a] }}
                  </td>
                  <td>
                    {{ $reincidentes->reincidentes[$a] }}
                  </td>
                </tr>
@endfor
			</tbody>
		</table>
	</div>

</div>

@else
	<h2>No hay VTs cargados en el sistema para el día de hoy.</h2>
@endif
@endsection

@section('scripts')

  @include('partials.modalConfirm')
  <script src="/js/jquery-ui.min.js"></script>


@endsection

@section('css')
  <link rel="stylesheet" href="/css/jquery-ui.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.structure.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.theme.min.css">

@endsection