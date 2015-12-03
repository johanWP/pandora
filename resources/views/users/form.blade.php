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
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
    <!-- End password textfield -->
    <!-- Begin password_confirmation textfield -->
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirmar Password:') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
    <!-- End password_confirmation textfield -->

    <!-- Begin  textfield -->
            <div class="form-group">
                {!! Form::label('activityList', 'Actividades:') !!}
                {!! Form::select('activityList[]', $activities , null, ['class' => 'form-control', 'multiple', 'id'=>'activityList']) !!}
            </div>
    <!-- End  textfield -->
    <!-- Begin checkbox active -->
            <div class="form-group">
                <label> Marque si el usuario está activo
                {!! Form::checkbox('active', 1, ['class' => '']) !!}
                </label>
            </div>
    <!-- End active textfield -->
    @if(Auth::user()->securityLevel == 100)
    <!-- Begin company_id textfield -->
            <div class="form-group">
                {!! Form::label('company_id', 'Company ID:') !!}
                {!! Form::text('company_id', 1, ['class' => 'form-control']) !!}
            </div>
    <!-- End company_id textfield -->
    @endif
    <!-- Begin Submit button -->
<!-- Begin security_level textfield -->
        <div class="form-group">
            <select id="securityLevel" class="form-control" name="securityLevel">
              <option value="" selected="selected">Seleccione el rol del usuario...</option>
              <option value="10">Técnico</option>
              <option value="20">Supervisor</option>
              <option value="30">Jefe</option>
              <option value="40">Gerente</option>
              <option value="50">Director</option>

            </select>
{{--
            {!! Form::label('securityLevel', 'Nivel de Seguridad:') !!}
            {!! Form::number('securityLevel', null, ['class' => 'form-control']); !!}
--}}
        </div>
<!-- End security_level textfield -->
        <div class="form-group">
                {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
        </div>
    <!-- End Submit Button -->


@section('scripts')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
    <script>
      $('#activityList').select2({
        'placeholder'   :   'Clic para seleccionar una actividad'
      });
    </script>
@endsection