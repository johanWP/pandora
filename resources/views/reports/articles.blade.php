@extends('master')

@section('title')
    Reporte de Artículos
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Reporte de Artículos de {{ Auth::user()->currentCompany->name }}</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-primary" href="{{ action('ReportsController@excelArticles') }}"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>
</div>

    <hr/>
<div class="row">
    @if($articles->count()>0)
    <table class="table table-responsive">
      <thead>
         <tr>
            <th>Código del Producto</th>
            <th>Nombre</th>
            <th>Activo</th>
         </tr>
      </thead>
            @foreach($articles as $article)
               <tr>
                  <td>{{ $article->product_code }}</td>
                  <td>{{ $article->name }}</td>
                  <td>{{ $article->active }}</td>
               </tr>
            @endforeach
    </table>
    @else
      <p>No hay artículos cargados para esta empresa.</p>
    @endif
</div>

@endsection