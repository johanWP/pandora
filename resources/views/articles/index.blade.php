@extends('master')

@section('title')
Artículos
@endsection

@section('content')
    <h1>Artículos </h1>
    <hr />

    <p><b><a href="{{ action('ArticlesController@create') }}">Incluir nuevo artículo</a></b></p>
    @if($articles->count() > 0)
        @foreach($articles as $article)
            <h2><a href="{{ action('ArticlesController@edit', $article->id) }}">{{ $article->name }}</a></h2>
        @endforeach
    @else
        <h2>No hay artículos cargados en el inventario.</h2>
    @endif
@endsection