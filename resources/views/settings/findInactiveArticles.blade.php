@extends('master')

@section('title')
    Ajustes
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h3>¡Los artículos se marcaron con éxito!</h3>
        </div>
    </div>
    <hr/>
    <p>Ahora hay <strong>{{ $activos }}</strong> artículos activos y <strong>{{$inactivos}}</strong> inactivos.</p>
    <img src="/batman.gif"/>
@endsection