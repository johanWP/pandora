@extends('master')

@section('title')
    Auditoria de Serializados por Almacen
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Auditoría de serializados</h1>
  </div>

</div>

    <hr/>

@if(isset($results))
<div class="row">

    <table class="table table-responsive">
      <thead>
         <tr>
            <th>id</th>
            <th>article_id</th>
            <th>serial</th>
            <th>origin_id</th>
            <th>destination_id</th>
         </tr>
      </thead>
            @foreach($results as $movement)
               <tr>
                  <td>{{ $movement['id'] }}</td>
                  <td>{{ $movement['article_id'] }}</td>
                  <td>{{ $movement['serial'] }}</td>
                  <td>{{ $movement['origin_id'] }}</td>
                  <td>{{ $movement['destination_id'] }}</td>
               </tr>
            @endforeach
    </table>

</div>
@else
  <h1>No hay movimientos duplicados para este almacén</h1>
@endif

<div class="row">
  <div class="col-sm-10">
    <h1>Serialies a revisar manualmente (destino 0 != origen 1)</h1>
  </div>

</div>

<hr/>

@if(isset($manuales))
<div class="row">

    <table class="table table-responsive">
      <thead>
         <tr>

            <th>article_id</th>
            <th>serial</th>

         </tr>
      </thead>
            @foreach($manuales as $movement)
               <tr>
                  
                  <td>{{ $movement['article_id'] }}</td>
                  <td>{{ $movement['serial'] }}</td>

               </tr>
            @endforeach
    </table>

</div>
@else
  <h1>No hay movimientos a revisar manualmente para este almacén</h1>
@endif  
  
@endsection