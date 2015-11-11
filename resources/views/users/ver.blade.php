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
      <caption>Datos del perfil</caption>
      <tbody>
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
            <td>{{ $user->company_id }}</td>
         </tr>
         <tr>
            <th>ID Empleado</th>
            <td>{{ $user->employee_id }}</td>
         </tr>
      </tbody>
    </table>
  </div>
</div>
@unless($user->activities->isEmpty())
   <div class="row">
     <div>
        <h3>Actividades Permitidas</h3>
        <ul>
        @foreach($user->activities as $activity)
           <li>{{ $activity->name }}</li>
        @endforeach
        </ul>
     </div>
   </div>
@endunless

<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $user->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endsection