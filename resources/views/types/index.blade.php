@extends('master')

@section('title')
    Tipos de Almacén
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Tipos de Almacén</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-success" href="tipos/create"><i class="fa fa-plus fa-fw"></i> Crear Nuevo</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
<div class="row">
@if($types->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($types as $type)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left"><a href="{{ action('TypesController@edit', $type->id) }}">{{ $type->name }}</a></p>
                  </td>
                  <td class="text-right">
                    <a href="#" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="#" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Eliminar</a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>

</div>

@else
	<h2>No hay tipos de almacén cargados en el sistema.</h2>
@endif
@endsection
