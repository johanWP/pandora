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
{{--

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

--}}
    <!-- Begin  ActivityList -->
            <div class="form-group">
                {!! Form::label('activityList', 'Actividades:') !!}
                {!! Form::select('activityList[]', $activities , null, ['class' => 'form-control', 'multiple', 'id'=>'activityList']) !!}
            </div>
    <!-- End  ActivityList -->
    <!-- Begin  WarehouseList -->
            <div class="form-group">
                {!! Form::label('warehouseList', 'Almacenes Permitidos:') !!}
                {!! Form::select('warehouseList[]', $warehouses , null, ['class' => 'form-control', 'multiple', 'id'=>'warehouseList']) !!}
            </div>
    <!-- End  WarehouseList -->

    <!-- Begin checkbox active -->
            <div class="form-group">
                <label> Marque si el usuario está activo
                {!! Form::checkbox('active', 1, $active) !!}
                </label>
            </div>
    <!-- End active textfield -->
    <!-- Begin Submit button -->
<!-- Begin security_level textfield -->
        <div class="form-group">
            {!! Form::select('securityLevel', $securityLevel , null, ['class' => 'form-control', 'id'=>'securityLevel']) !!}

            {{--
                        <select id="securityLevel" class="form-control" name="securityLevel">
                          <option value="" selected="selected">Seleccione el rol del usuario...</option>
                          <option value="10">Técnico</option>
                          <option value="20">Supervisor</option>
                          <option value="30">Jefe</option>
                          <option value="40">Gerente</option>
                          <option value="50">Director</option>
                        </select>
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
        'placeholder'   :   'Clic para asignar actividades'
      });
      $('#warehouseList').select2({
        'placeholder'   :   'Clic para asignar almacenes'
      });
    </script>
@endsection