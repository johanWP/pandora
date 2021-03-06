@extends('master')

@section('title')
    Inventario por Almacén
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Inventario por Almacén - Version alternativa</h1>
  </div>
</div>

    <hr/>
<div class="row">
  <div>
     <a href="/reportes/articulosPorAlmacen" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
  </div>
</div>
<div class="row">
  @foreach($result as $warehouse)
      <div class="col-sm-10">
        <h3>{{ $warehouse['name'] }} </h3>
      </div>
      @if(empty($warehouse['inventory']))
        <p>El Almacén está vacío</p>
      @else
        <div class="col-sm-2"><br/>
            <a class="btn btn-primary" href="/reportes/excelArticulosPorAlmacen/{{ $warehouse['id'] }}"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
        </div>

      <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Serial</th>
         </tr>
      </thead>
      <tbody>

        @foreach($warehouse['inventory'] as $article)
 
               <tr>
                  <td>{{ $article['product_code'] }}</td>
                  <td>{{ $article['name'] }}</td>
                  <td>{{ $article['cantidad'] }}</td>
                  <td class="text-center">
                  @if($article['serializable']!='0')
                    <a href="/reportes/seriadosPorAlmacen/{{ $warehouse['id'] }}/{{ $article['product_code'] }}">ver seriales</a>
                  @endif  
                  </td>
               </tr>
         
        @endforeach

      @endif
      </tbody>
    </table>

  @endforeach
</div>

@endsection