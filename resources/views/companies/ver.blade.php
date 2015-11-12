@extends('master')

@section('title')
    Detalle de Empresas
@endsection

@section('content')
<h1>{{ $company->name }}</h1>

   <p>Aquí va el detalle de cada empresa</p>

@if ($company->parent == 1)
    <h3>Empresa Parent</h3>
@endif
<!-- Begin Submit button -->
    <div class="form-group">
            <a class="btn btn-primary" href="{{  $company->id . '/edit' }}">Editar</a>
    </div>
<!-- End Submit Button -->
@endsection