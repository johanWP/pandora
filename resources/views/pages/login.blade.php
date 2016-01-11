{{--
<div class="col-sm-9">
    <h2>Premium quality free onepage template</h2>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
    </p>
    <p></p>
</div>
<div class="col-sm-3 text-right">
    <a class="btn btn-primary btn-lg" href="#">Download Now!</a>
</div>
--}}
<div class="row">
  <div class="col-sm-12">
      {!! Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'form-inline']) !!}

        <div class="form-group">
          {!! Form::label('username', 'Nombre de usuario:', ['for' => 'username']) !!}
          {!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=>'Escriba su nombre de usuario']) !!}

        </div>
        <div class="form-group">
          {!! Form::label('password', 'Contraseña:', ['for' => 'password']) !!}
          {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Escriba su password']) !!}
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" style="margin-top: 0px">Ingresar</button>
        </div>

        <div class="form-group">
            {!! link_to('password/email', $title='Olvidé mi contraseña', $attributesm= null, $secure=null) !!}
        </div>
      {!! Form::close() !!}

  </div>
</div>
