@extends('master')

@section('title')
Editar Almacén: {{ $warehouse->name }}
@endsection

@section('content')

    <h1>Editar Almacén: {{ $warehouse->name }}</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')
<?php
$active = $warehouse->active
?>
    {!! Form::model($warehouse, ['method' => 'PATCH', 'url' => 'almacenes/' . $warehouse->id]) !!}
        @include('warehouses.form', ['submitButtonText' => 'Guardar Cambios', 'active' => $active])
    {!! Form::close() !!}

@endsection