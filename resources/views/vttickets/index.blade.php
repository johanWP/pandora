@extends('master')

@section('title')
    VT Tickets Registrados
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Tickets VT</h1>
  </div>
</div>
<hr/>

<div class="row">
    @include('search.autocomplete')
</div>

@if($vttickets->count() > 0)
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th><h3>Fecha</h3></th>
				<th><h3>Cliente</h3></th>
			</tr>
			</thead>
			<tbody>
			@foreach($vttickets as $vtticket)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left">
                      <a href="{{ action('VtticketsController@show', $vtticket->id) }}">{{ $vtticket->order_number }}</a>
                    </p>
                  </td>
                  <td>
                    {{ $vtticket->date }}
                  </td>
                  <td>
                    {{ $vtticket->customer_id }}
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>

</div>

<div class="row">
    <div class="text-center">{!! $vttickets->render() !!}</div>
</div>
@else
	<h2>No hay Artículos cargados en el sistema.</h2>
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
          source: "/search/autocomplete/vttickets",
          minLength: 3,
          select: function(event, ui)
          {
              $('#q').val(ui.item.value);
              $('#btnDetalle').attr('href','/vttickets/'+ ui.item.id)
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