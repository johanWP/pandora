@extends('generic')

@section('title')
    Registrar nuevo usuario
@endsection

@section('content')
    <h1>Registro de nuevo usuario</h1>
    <hr/>
    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}
    <!-- Begin username textfield -->
            <div class="form-group">
                {!! Form::label('username', 'Nombre de usuario:') !!}
                {!! Form::text('username', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End username textfield -->
    <!-- Begin firstName textfield -->
            <div class="form-group">
                {!! Form::label('firstName', 'Nombre:') !!}
                {!! Form::text('firstName', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End firstName textfield -->
    <!-- Begin lastName textfield -->
            <div class="form-group">
                {!! Form::label('lastName', 'Apellido:') !!}
                {!! Form::text('lastName', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End lastName textfield -->

    <!-- Begin email textfield -->
            <div class="form-group">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End email textfield -->
    <!-- Begin password textfield -->
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::text('password', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End password textfield -->
    <!-- Begin password_confirmation textfield -->
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirmar Password:') !!}
                {!! Form::text('password_confirmation', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End password_confirmation textfield -->
    <!-- Begin activity_id textfield -->
            <div class="form-group">
                {!! Form::label('activity_id', 'Activity ID:') !!}
                {!! Form::text('activity_id', 1, ['class' => 'form-control']) !!}
            </div>
    <!-- End activity_id textfield -->
    <!-- Begin company_id textfield -->
            <div class="form-group">
                {!! Form::label('company_id', 'Company ID:') !!}
                {!! Form::text('company_id', 1, ['class' => 'form-control']) !!}
            </div>
    <!-- End company_id textfield -->

<!--
        <div>
            Password
            <input type="password" name="password">
        </div>

        <div>
            Confirm Password
            <input type="password" name="password_confirmation">
        </div>
    -->
    <!-- Begin Submit button -->
        <div class="form-group">
                {!! Form::submit('Registrar', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    <!-- End Submit Button -->

    </form>
@endsection