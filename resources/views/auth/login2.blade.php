@extends('generic')

@section('title')
    Ingresar al Sistema
@endsection

@section('content')
    <h1>Ingreso al Sistema de Inventario</h1>
    <hr/>
    @include('partials.flash')
 {!! Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

    <!-- Begin username textfield -->
            <div class="form-group">
                {!! Form::label('username', 'Nombre de usuario:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>'Escriba su nombre de usuario']) !!}
                </div>
            </div>
    <!-- End username textfield -->
<br/>
    <!-- Begin password textfield -->
            <div class="form-group">
                {!! Form::label('password', 'Contraseña:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Escriba su password']) !!}
                </div>
            </div>
    <!-- End username textfield -->

     <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <div class="checkbox">
            <label for="remember">
              <input type="checkbox" value="1" name="rememberMe" id="rememberMe"> Recordarme en este equipo
            </label>
          </div>
        </div>
      </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" class="btn btn-primary">Ingresar</button>
    </div>
  </div>
{!! Form::close() !!}

@endsection