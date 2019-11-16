@extends('master')

@section('title')
    Detalle del almacén {{ $warehouse->name }}
@endsection

@section('content')
<h1>{{ $warehouse->name }}</h1>
<hr/>
<div class="row">
  <div class="table-responsive">

    <table class="table table-striped">
      <caption>Datos del almacén</caption>
      <tbody>
         <tr>
            <th>Activo</th>
            <td>
            @if ($warehouse->active == 0)
                No
            @else
                Si
            @endif
            </td>
         </tr>
         <tr>
            <th>Nombre</th>
            <td>{{ $warehouse->name }}</td>
         </tr>
         <tr>
            <th>Descripción</th>
            <td>{{ $warehouse->description }}</td>
         </tr>
         <tr>
            <th>Empresa</th>
            <td>{{ $company->name }}</td>
         </tr>
         <tr>
            <th>Actividad</th>
            <td>{{ $activity->name }}</td>
         </tr>
         <tr>
            <th>Tipo</th>
            <td>{{ $type->name }}</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $warehouse->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endsection