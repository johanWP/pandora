@extends('master')

@section('title')
    Editar {!! $article->name !!}
@endsection

@section('content')

    <h1>Editar {!! $article->name !!}</h1>
    <hr/>
 <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::model($article, ['method' => 'PATCH', 'url' => 'articulos/' . $article->id]) !!}
        @include('articles.form', ['submitButtonText' => 'Actualizar este Artículo'])
    {!! Form::close() !!}
@endsection