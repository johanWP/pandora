@extends('master')

@section('title')
    Detalles del movimiento
@endsection

@section('content')
<h1>Detalles del movimiento</h1>
<hr/>

<div class="row">
  <div class="table-responsive">
    <table class="table table-striped">
      <tbody>
         <tr>
            <th><p>Estatus</p></th>
            <td>
                <p>{{ $movement->status->name }}</p>
            </td>
         </tr>
         <tr>
            <th>Almacén de Origen</th>
            <td>{{ $movement->origin->name }}</td>
         </tr>
         <tr>
            <th>Artículo</th>
            <td>{{ $movement->article->name }}</td>
         </tr>
         <tr>
            <th>Cantidad</th>
            <td>{{ $movement->quantity }}</td>
         </tr>
         <tr>
            <th>Almacén de Destino</th>
            <td>{{ $movement->destination->name }}</td>
         </tr>
         <tr>
            <th>Realizado por</th>
            <td>{{ $movement->user->firstName }} {{ $movement->user->lastName }}</td>
         </tr>
         <tr>
            <th>Fecha de creación</th>
            <td>{{ $movement->created_at }}</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>

@if (Auth::user()->securityLevel >= 20)
<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $movement->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endif
@endsection