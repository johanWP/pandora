<!-- Begin nombre textfield -->
        <div class="form-group">
            {!! Form::label('name', 'Nombre:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
<!-- End nombre textfield -->

<!-- Begin Submit button -->
    <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>
<!-- End Submit Button -->
