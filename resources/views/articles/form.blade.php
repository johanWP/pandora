    <!-- Begin name textfield -->
            <div class="form-group">
                {!! Form::label('name', 'Nombre:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
    <!-- End name textfield -->
     <!-- Begin Barcode textfield -->
             <div class="form-group">
                 {!! Form::label('barcode', 'Código de Barras:') !!}
                 {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
             </div>
     <!-- End Barcode textfield -->

    <!-- Begin checkbox serializable -->
             <div class="form-group">
                 {!! Form::label('serializable', 'Marque si el artículo es serializable:') !!}
                 {!! Form::checkbox('serializable',1, false, ['class' => 'form-control']) !!}

             </div>
     <!-- End serializable checkbox -->

    <!-- Begin checkbox activo -->
             <div class="form-group">
                 {!! Form::label('active', 'Marque si el artículo está activo:') !!}
                 {!! Form::checkbox('active',1, false, ['class' => 'form-control', 'foo'=>'bar']) !!}

             </div>
     <!-- End activo checkbox -->
     <!-- Begin Submit button -->
         <div class="form-group">
                 {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
         </div>
     <!-- End Submit Button -->
