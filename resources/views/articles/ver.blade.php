@extends('master')

@section('title')
    Detalle del artículo {{ $article->name }}
@endsection

@section('content')
<h1>Detalle del artículo {{ $article->name }}</h1>
<hr/>
<div class="row">
  <div class="table-responsive">

    <table class="table table-striped">

      <tbody>
         <tr>
            <th>Nombre</th>
            <td>{{ $article->name }}</td>
         </tr>
         <tr>
            <th>Código</th>
            <td>{{ $article->product_code }}</td>
         </tr>
         <tr>
            <th>Código de Barras</th>
            <td>{{ $article->barcode }}</td>
         </tr>
         <tr>
            <th>Activo</th>
            <td>
            @if ($article->active == 0)
                No
            @else
                Si
            @endif
            </td>
         </tr>
         <tr>
            <th>Serializable</th>
            <td>
            @if ($article->serializable == 0)
                No
            @else
                Si
            @endif
            </td>
         </tr>
         <tr>
            <th>Favorito</th>
            <td>
            @if ($article->fav == 0)
                No
            @else
                Si
            @endif
            </td>
         </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $article->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endsection