@extends('master')

@section('title')
    Escritorio
@endsection

@section('content')
    <h1>Escritorio de {!! $user->firstName !!} </h1>
    <hr/>
    <p><a href="#">Cerrar sesión</a></p>
@endsection