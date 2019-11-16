@extends('master')

@section('title')
    Registrar nuevo usuario
@endsection

@section('content')
    <h1>Registrar nuevo usuario</h1>
    <hr/>
    @include('errors.list')

    {!! Form::open(['url' => 'usuarios']) !!}
    @include('users.form', ['submitButtonText' => 'Incluir Nuevo Usuario', 'active' => 1])
    {!! Form::close() !!}

@endsection