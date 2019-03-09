@extends('master')

@section('title')
    Planos
@endsection

@section('content')
    <h1>Localidades disponibles</h1>
    <ul class="list-group">
    @foreach ($locations as $location)
        <?PHP $thislocation = substr($location,-2); ?>
        <li class="list-group-item"><a href="/maps/{{ $thislocation }}">{{ $thislocation }}</a></li>
    @endforeach
    </ul>
@endsection