
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

    <!-- Begin Submit button -->
        <div class="form-group">
                {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
        </div>
    <!-- End Submit Button -->
