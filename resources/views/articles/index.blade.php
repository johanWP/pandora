@extends('master')

@section('title')
    Artículos Registrados
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Artículos Registrados</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-primary" href="{{ action('ArticlesController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
@if($articles->count() > 0)
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($articles as $article)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left">
                      <a href="{{ action('ArticlesController@show', $article->id) }}">{{ $article->name }}</a>
                    </p>
                  </td>
                  <td class="text-right">
                    <a href="{{ action('ArticlesController@edit', $article->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="#modalConfirm" id="btnDelete" class="btn btn-danger" data-toggle="modal" data-name="{{ $article->name }}" data-deleteMe="{{ $article->id }}">
                      <i class="fa fa-trash fa-fw"></i> Eliminar
                    </a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>

</div>

<div class="row">
    <div class="text-center">{!! $articles->render() !!}</div>
</div>
@else
	<h2>No hay Artículos cargados en el sistema.</h2>
@endif
@endsection

@section('scripts')

  @include('partials.modalConfirm')

@endsection