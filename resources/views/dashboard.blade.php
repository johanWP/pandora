@extends('master')

@section('title')
    Escritorio
@endsection

@section('content')
    <h1>Escritorio de {!! $user->firstName !!} </h1>
    <hr/>

    <div class="row">
    @if (Auth::user()->securityLevel < 20)
      <div class="col-sm-4">
         <div class="rcorners  text-center">
            <a href="/movimientos/create">
            <i class='fa fa-plus fa-3x'></i><br>
            Nuevo Movimiento</a>
         </div>
      </div>
      <div class="col-sm-4">
         <div class="rcorners  text-center">
         <a href="{!!URL::to('/movimientos/')!!}">
            <i class='fa fa-list-ol fa-3x'></i><br>
             Últimos Movimientos
            </a>

         </div>
      </div>
      <div class="col-sm-4">
         <div class="rcorners text-center">
         <a href="{!!URL::to('/logout')!!}">
         <i class="fa fa-sign-out fa-3x"></i><br>
         Salir del Sistema
         </a>
         </div>
      </div>
    @endif

@endsection