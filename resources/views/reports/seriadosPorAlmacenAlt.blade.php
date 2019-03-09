@extends('master')

@section('title')
    Inventario de seriados por Almacén
@endsection

@section('content')
 
<div class="row">
  <div class="col-sm-10">
    <h1>Inventario por seriados por Almacén</h1>
  </div>
</div>

    <hr/>
    
<h1>{{ $warehouse['name'] }}</h1>
    
<div class="row">
  <div>
     <a href="/reportes/articulosPorAlmacenAlt" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
  </div>
</div>
<div class="row">


      <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Serial</th>
            <th></th>
         </tr>
      </thead>
      <tbody>

       {!! Form::open(array('url' => '/movimientos/porseriales')) !!}
      <!--<form action="/movimientos/porseriales/" method="post">-->
      <!--<input type="hidden" name="id" value="{{ $warehouse['id'] }}">-->

        @foreach($result as $seriales)
 
               <tr>
                  <td>{{ $seriales['article_id'] }}</td>
                  <td>{{ $seriales['article_desc'] }}</td>
                  <td></td>
                  <td class="text-center">
                  {{ $seriales['serial'] }}
                  </td>
                    <td><input type="checkbox" name="serial[]" value="{{ $seriales['serial'] }}"></td>
               </tr>
         
        @endforeach
      <tr><td colspan="5">
        <h1>Transferencia rápida de elementos serializados</h1>
        <div class="form-group">
        <label>Almacén de destino</label>

        <select name="destination_id">
        @foreach($wh as $whs)
          <option value="{{ $whs->id }}">{{ $whs->name }}</option>
        @endforeach
        </select>
        </div>
        <div class="form-group">
        <label>Remito</label>
        {!! Form::text('remito') !!}
        </div>
        <div class="form-group">
        <label>Notas</label>
        {!! Form::text('note') !!}
        </div>      
        <div class="form-group">
        <label>Ticket</label>
        {!! Form::text('ticket') !!}
        </div>           
      
      {!! Form::hidden('origin_id', $warehouse['id']) !!}
      {!! Form::hidden('article_id', $aid) !!}
      {!! Form::submit('Transferir') !!}
      </td></tr>
      <!--</form>-->
        {!! Form::close() !!}
      </tbody>
    </table>


@endsection