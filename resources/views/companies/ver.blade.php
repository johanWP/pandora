@extends('master')

@section('title')
    Detalle de Empresas
@endsection

@section('content')
<h1>{{ $company->name }}</h1>

   <p>Aquí va el detalle de cada empresa</p>

    @unless($company->activities->isEmpty())

       <p class="h2">Actividades:</p>
        <ul>
        @foreach($company->activities as $activity)
            <li>{{$activity->name}}</li>
       @endforeach
       </ul>
    @endunless

<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $company->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endsection