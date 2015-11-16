@extends('master')

@section('title')
    Escritorio
@endsection

@section('content')
    <h1>Escritorio de {!! $user->firstName !!} </h1>
    <hr/>

    <div class="row">
      <div class="col-sm-4">
         <div class="rcorners">Esto tiene bordes redondeados</div>
      </div>
      <div class="col-sm-4">
         <div class="rcorners">Esto tiene bordes redondeados</div>
      </div>
      <div class="col-sm-4">
         <div class="rcorners">Esto tiene bordes redondeados</div>
      </div>


@endsection