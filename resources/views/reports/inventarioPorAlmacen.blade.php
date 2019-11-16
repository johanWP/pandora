@extends('master')

@section('title')
    Inventario por Almacén
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Inventario por Almacén - Version mini</h1>
  </div>
</div>

    <hr/>
<div class="row">
  <div>
     <a href="/reportes/articulosPorAlmacen" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
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
         </tr>
      </thead>
      <tbody>
@foreach($result as $warehouse)

               <tr>
                  <td>{{ $warehouse['product_code'] }}</td>
                  <td>{{ $warehouse['name'] }}</td>
                  <td>{{ $warehouse['cantidad'] }}</td>
                  <td class="text-center">
                  @if($warehouse['serializable']==1)
                    <a href="">ver seriales</a>
                  @endif
                  </td>
               </tr>
@endforeach

      
      </tbody>
    </table>

</div>

@endsection