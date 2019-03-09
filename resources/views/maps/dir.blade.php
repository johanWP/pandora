@extends('master')

@section('title')
    Planos
@endsection

@section('content')
    <h1>{{ $location }}</h1>
    <ul class="list-group">
    @foreach ($files as $file)
        
        <?PHP $thisfile = explode("/",$file); ?>
        <li class="list-group-item"><a href="/maps/{{ $thisfile[6] }}/{{ $thisfile[7] }}">{{ $thisfile[7] }}</a></li>
    @endforeach
    </ul>
@endsection