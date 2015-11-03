@extends('master')

@section('title')
    Ingresar al Sistema
@endsection

@section('content')
    @if ($errors->any())
        <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error}}</li>
        @endforeach
        </ul>
    @endif
    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}
    <!-- Begin username textfield -->
            <div class="form-group">
                {!! Form::label('email', 'Nombre de usuario:') !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End username textfield -->

    <!-- Begin password textfield -->
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End password textfield -->
    <!-- Begin checkbox remember -->
             <div class="form-group">
                 {!! Form::label('remember', 'Recordarme en este equipo:') !!}
                 {!! Form::checkbox('remember', '0', ['class' => 'form-control']) !!}

             </div>
    <!-- End remember textfield -->
    <!-- Begin Submit button -->
        <div class="form-group">
                {!! Form::submit('Ingresar', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    <!-- End Submit Button -->

@endsection