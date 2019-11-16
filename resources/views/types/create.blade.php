@extends('master')

@section('title')
    Crear Nuevo Tipo de Almacén
@endsection

@section('content')
    <h1>Crear Nuevo Tipo de Almacén</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')
    {!! Form::open(['url' => 'tipos']) !!}

    @include('types.form', ['submitButtonText' => 'Incluir Nuevo Tipo de Almacén'])

    {!! Form::close() !!}
@endsection