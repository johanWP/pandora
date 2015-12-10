@extends('master')

@section('title')
    Inventario por Almacén
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Inventario por Almacén</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-primary" href="#"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>
</div>

    <hr/>
<div class="row">
  @foreach($result as $warehouse)
  <h3>{{ $warehouse['name'] }}</h3>
      @if(empty($warehouse['inventory']))
        <tr><td colspan="3"><p>El Almacén está vacío</p></td></tr>
      @else
    <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
         </tr>
      </thead>


        @foreach($warehouse['inventory'] as $article)
           <tr>
              <td>{{ $article['product_code'] }}</td>
              <td>{{ $article['name'] }}</td>

              <td>{{ $article['cantidad'] }}</td>
           </tr>
        @endforeach

      @endif
    </table>

  @endforeach
</div>

@endsection