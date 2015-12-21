@extends('generic')

@section('title')
   Restablecer contraseña
@endsection

@section('contentx')

<div class="row">
    @include('partials.flash')
</div>







@endsection

@section('content')
<h1>Restablecer Contraseña</h1>
<hr/>

<div class="col-sm-10">
  @include('partials.flash')
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-important" style="padding-left:40px;margin-top:1%;">

          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
    </div>
    @endif

</div>

  <div class="col-sm-10">
    {!! Form::open(['url' => 'password/email', 'method' => 'POST']) !!}
        <div class="form-group">

          {!! Form::label('email', 'Email:', ['for' => 'email']) !!}
          {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Escriba su email']) !!}
          </div>
          <div class="form-group">
          {!! Form::label('username', 'Nombre de usuario:', ['for' => 'username']) !!}
          {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>'Escriba su nombre de usuario']) !!}
          </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" style="margin-top: 0px">Resetear</button>
        </div>
      {!! Form::close() !!}

  </div>

@endsection