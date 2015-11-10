@extends('master')

@section('title')
    Empresas Registradas
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Empresas Registradas</h1>
  </div>
  <div class=""><br/>
    <a class="btn btn-success" href="{{ action('CompaniesController@create') }}"><i class="fa fa-plus fa-fw"></i> Crear Nueva</a>
  </div>
</div>

    <hr/>

<div class="row">
  <div class="col-sm-5 vcenter">
    <input type="text" placeholder="Buscador"> <input class="btn btn-default" type="submit" value="Buscar">
  </div>
</div>
<div class="row">
@if($companies->count() > 0)
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
			  <th><h3>Nombre</h3></th>
			  <th class="text-center" colspan="2"><h3>Acciones</h3></th>

			</tr>
			</thead>
			<tbody>
			@foreach($companies as $company)
                <tr>
                  <td class="col-sm-10">
                    <p class="text-left">
                      <a href="{{ action('CompaniesController@edit', $company->id) }}">{{ $company->name }}</a>
                    </p>
                  </td>
                  <td class="text-right">
                    <a href="{{ action('CompaniesController@edit', $company->id) }}" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Editar</a>
                  </td>
                  <td>
                    <a href="{{ action('CompaniesController@edit') }}" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Eliminar</a>
                  </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>

</div>
<div class="row">
    <div class="text-center">{!! $companies->render() !!}</div>
</div>
@else
	<h2>No hay Empresas cargadas en el sistema.</h2>
@endif
@endsection
