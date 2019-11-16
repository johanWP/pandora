@extends('master')

@section('title')
    Agregar Nueva Actividad
@endsection

@section('content')
    <h1>Agregar Nueva Actividad</h1>
    <hr/>
    {!! Form::open(['url' => '/actividades']) !!}

        @include('activities.form', ['submitButtonText' => 'Incluir Nueva Actividad'])
    {!! Form::close() !!}
@endsection