<!-- Begin name textfield -->
        <div class="form-group">
            {!! Form::label('name', 'Actividad:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la actividad']) !!}
        </div>
<!-- End name textfield -->
<!-- Begin Submit button -->
    <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>
<!-- End Submit Button -->