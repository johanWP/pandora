@extends('master')

@section('title')
Editar Usuario: {{ $user->firstName }} {{ $user->lastName }}
@endsection

@section('content')

    <h1>Editar Usuario: {{ $user->firstName }} {{ $user->lastName }}</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')
<?php
$active = $user->active;
?>
    {!! Form::model($user, ['method' => 'PATCH', 'url' => 'usuarios/' . $user->id]) !!}
        @include('users.form', ['submitButtonText' => 'Guardar Cambios', 'active' => $active])
    {!! Form::close() !!}

@endsection