<!-- Begin name textfield -->
        <div class="form-group">
            {!! Form::label('name', 'Nombre:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
<!-- End name textfield -->
<!-- Begin description textfield -->
        <div class="form-group">
            {!! Form::label('description', 'Descripción:') !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>
<!-- End description textfield -->
<!-- Begin Activity select -->
        <div class="form-group">
            {!! Form::label('activity_id', 'Actividad:') !!}
            {!! Form::select('activity_id', $activities , null, ['class' => 'form-control']) !!}
        </div>
<!-- End Type select -->
<!-- Begin Activity select -->
        <div class="form-group">
            {!! Form::label('type_id', 'Tipo de Almacén:') !!}
            {!! Form::select('type_id', $types , null, ['class' => 'form-control']) !!}
        </div>
<!-- End type select -->
<!-- Begin checkbox activo -->
         <div class="form-group">
             {!! Form::label('active', 'Marque si el almacén está activo &nbsp;') !!}
             {!! Form::checkbox('active',1, $active) !!}

         </div>
 <!-- End activo checkbox -->


            {{--{!! Form::hidden('company_id', Auth::user()->company_id, ['class' => 'form-control']) !!}--}}

<!-- Begin Submit button -->
    <div class="form-group">

            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>
<!-- End Submit Button -->

