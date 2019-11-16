@extends('master')

@section('title')
    Perfil del Usuario
@endsection

@section('content')
<h1>{{ $user->firstName }} {{ $user->lastName }}</h1>
<hr/>

<div class="row">
  <div class="table-responsive">
    <table class="table table-striped">
      <tbody>
         <tr>
            <th>Activo</th>
            <td>
            @if ($user->active == 0)
                No
            @else
                Si
            @endif
            </td>
         </tr>
         <tr>
            <th>Usuario</th>
            <td>{{ $user->username }}</td>
         </tr>
         <tr>
            <th>Nombre</th>
            <td>{{ $user->firstName }}</td>
         </tr>
         <tr>
            <th>Apellido</th>
            <td>{{ $user->lastName }}</td>
         </tr>
         <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
         </tr>
         <tr>
            <th>Empresa</th>
            <td>{{ $user->company->name }}</td>
         </tr>
{{--
         <tr>
            <th>ID Empleado</th>
            <td>{{ $user->employee_id }}</td>
         </tr>
--}}
      </tbody>
    </table>
  </div>
</div>

   <div class="row">
   @unless($user->activities->isEmpty())
     <div class="col-sm-6">
        <h3>Actividades Permitidas</h3>
        <ul>
        @foreach($user->activities as $activity)
           <li>{{ $activity->name }}</li>
        @endforeach
        </ul>
     </div>
   @endunless
   @unless($user->warehouses->isEmpty())
       <div class="col-sm-6">
           <h3>Almacenes Permitidos</h3>
           <ul>
               @foreach($user->warehouses as $warehouse)
                   <li>{{ $warehouse->name }}</li>
               @endforeach
           </ul>
       </div>
   @endunless
   </div>

@if (Auth::user()->securityLevel >= 40 )
<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $user->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endif
@endsection