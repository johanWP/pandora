@extends('master')

@section('title')
    Crear Nuevo Tipo de Almacén
@endsection

@section('content')
    <h1>Crear Nuevo Tipo de Almacén</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')
    {!! Form::model($type, ['method' => 'PATCH', 'url' => 'tipos/' . $type->id]) !!}

    @include('types.form', ['submitButtonText' => 'Guardar Cambios'])

    {!! Form::close() !!}
@endsection