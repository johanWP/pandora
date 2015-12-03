@extends('master')

@section('title')
    Reporte de Artículos
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Reporte de Artículos</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-success" href="{{ action('ReportsController@excelArticles') }}"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>
</div>

    <hr/>
<div class="row">
    <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código del Producto</th>
            <th>Nombre</th>
            <th>Activo</th>
            <th>Código de Barras</th>
         </tr>
      </thead>
            @foreach($articles as $article)
               <tr>
                  <td>{{ $article->product_code }}</td>
                  <td>{{ $article->name }}</td>
                  <td>{{ $article->active }}</td>
                  <td>{{ $article->barcode }}</td>
               </tr>
            @endforeach
    </table>

</div>

@endsection