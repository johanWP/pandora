@extends('master')

@section('title')
    Empresas
@endsection

@section('content')
    <h1>Empresas Registradas</h1>
    <hr />
    <p><b><a href="{{ action('CompaniesController@create') }}">Incluir nueva Empresa</a></b></p>
    @if ($companies->count() > 0 )
    @foreach($companies as $company)
        <h2><a href="{{ action('CompaniesController@show', $company->id) }}">{{ $company->name }}</a></h2>
    @endforeach
    @else
        <h2>No hay empresas para mostrar.</h2>
    @endif
@endsection