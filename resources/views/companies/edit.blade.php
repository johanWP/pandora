@extends('master')

@section('title')
Editar Empresa: {!! $company->name !!}
@endsection

@section('content')

    <h1>Editar Empresa: {!! $company->name !!}</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::model($company, ['method' => 'PATCH', 'url' => 'empresas/' . $company->id]) !!}
        @include('companies.form', ['submitButtonText' => 'Guardar Cambios'])
    {!! Form::close() !!}

@endsection