@extends('master')

@section('title')
    Detalles del movimiento
@endsection

@section('content')
    <h1>Detalles del movimiento</h1>
    <hr/>

<<<<<<< HEAD
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
            <th>Serial</th>
            <td>{{ $movement->serial }}</td>
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
            <th>Ticket</th>
            <td>{{ $movement->ticket }}</td>
         </tr>
         <tr>
            <th>Remito</th>
            <td>{{ $movement->remito }}</td>
         </tr>
      @if ($movement->approved_by != 0)
         <tr>
            <th>Aprobado por</th>
=======
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
                    <th>Serial</th>
                    <td>{{ $movement->serial }}</td>
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
                    <th>Ticket</th>
                    <td>{{ $movement->ticket }}</td>
                </tr>
                <tr>
                    <th>Remito</th>
                    <td>{{ $movement->remito }}</td>
                </tr>
                @if ($movement->approved_by != 0)
                    <tr>
                        <th>Aprobado por</th>
>>>>>>> Development

                        <td>{{ $approved->firstName }} {{ $approved->lastName }}</td>
                    </tr>
                @endif
                @if ($movement->deleted_by != 0)
                    <tr>
                        <th>Eliminado por</th>
                        <td>{{ $deleted->firstName }} {{ $deleted->lastName }} </td>
                    </tr>
                @endif
                <tr>
                    <th>Fecha de creación</th>
                    <td>{{ $movement->created_at }}</td>
                </tr>
                <tr>
                    <th>Notas / Observaciones</th>
                    <td>{{ $movement->note }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <a class="btn btn-default" href="#" onclick="window.history.back()"><i class="fa fa-chevron-left fa-fw"></i> Volver</a>
    </div>
    {{--

    @if (Auth::user()->securityLevel >= 20)
    <!-- Begin Submit button -->
        <div class="form-group">
                <a class="btn btn-primary" href="{{  $movement->id . '/edit' }}">Editar</a>
        </div>
    <!-- End Submit Button -->
    @endif

    --}}
@endsection