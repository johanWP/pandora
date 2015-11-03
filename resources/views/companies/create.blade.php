@extends('master')

@section('title')
Nueva Empresa
@endsection

@section('content')
    <h1>Incluir una nueva empresa</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::open(['url' => 'empresas']) !!}
    @include('companies.form', ['submitButtonText' => 'Incluir Nueva Empresa'])

    {!! Form::close() !!}

@endsection