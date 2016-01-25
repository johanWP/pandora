@extends('master')

@section('title')
    Crear nuevo artículo
@endsection

@section('content')

    <p class="h1">Incluir Nuevo Artículo</p>
    <hr/>

    @include('errors.list')

    {!! Form::open(['url' => 'articulos']) !!}
        @include('articles.form', ['submitButtonText' => 'Incluir nuevo artículo', 'active'=>1, 'serializable'=>0])
    {!! Form::close() !!}
@endsection