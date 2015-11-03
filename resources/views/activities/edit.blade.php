@extends('master')

@section('title')
    Editar Actividad: {{ $activity->name }}
@endsection

@section('content')

    <h1>Editar Actividad: {{ $activity->name }}</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::model($activity, ['method' => 'PATCH', 'url' => 'actividades/' . $activity->id]) !!}
        @include('activities.form', ['submitButtonText' => 'Guardar Cambios'])
    {!! Form::close() !!}
@endsection