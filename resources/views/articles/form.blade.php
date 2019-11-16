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

<!-- Begin product_code textfield -->
        <div class="form-group">
            {!! Form::label('product_code', 'Código del Producto:') !!}
            {!! Form::text('product_code', null, ['class' => 'form-control']) !!}
        </div>
<!-- End product_code textfield -->

    <!-- Begin checkbox serializable -->
             <div class="form-group">
                 {!! Form::label('serializable', 'Marque si el artículo es serializable &nbsp;') !!}
                 {!! Form::checkbox('serializable',1, $serializable) !!}

             </div>
     <!-- End serializable checkbox -->

    <!-- Begin checkbox activo -->
             <div class="form-group">
                 {!! Form::label('active', 'Marque si el artículo está activo &nbsp;') !!}
                 {!! Form::checkbox('active',1, $active) !!}

             </div>
     <!-- End activo checkbox -->
    <!-- Begin checkbox fav -->
             <div class="form-group">
                 {!! Form::label('fav', 'Marque si el artículo es un favorito &nbsp;') !!}
                 {!! Form::checkbox('fav',1, $fav) !!}

             </div>
     <!-- End activo checkbox -->
     <!-- Begin Submit button -->
         <div class="form-group">
                 {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
         </div>
     <!-- End Submit Button -->
