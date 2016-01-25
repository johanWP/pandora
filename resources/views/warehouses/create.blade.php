@extends('master')

@section('title')
    Registrar nuevo almacén
@endsection

@section('content')
    <h1>Registrar nuevo almacén</h1>
    <hr/>
    @include('errors.list')

    {!! Form::open(['url' => 'almacenes']) !!}
    @include('warehouses.form', ['submitButtonText' => 'Incluir Nuevo Almacén', 'active'=>'1'])
    {!! Form::close() !!}

@endsection