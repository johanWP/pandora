<!-- Begin remito textfield -->
        <div class="form-group">
            {!! Form::label('remito', 'Remito:') !!}
            {!! Form::text('remito', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
        </div>
<!-- End remito textfield -->
<!-- Begin origin_id select -->
        <div class="form-group">
            {!! Form::label('origin_id', 'Almacén de Origen:') !!}
            {!! Form::select('origin_id', $warehouseList, null, ['class' => 'form-control','placeholder' => 'Seleccione el origen...']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin quantity textfield -->
        <div class="form-group">
            {!! Form::label('quantity', 'Cantidad:') !!}
            {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
        </div>
<!-- End quantity textfield -->

<!-- Begin article_id select -->
        <div class="form-group">
            {!! Form::label('article_id', 'Artículo:') !!}
            {!! Form::select('article_id', $warehouseList, null, ['id'=>'article_id', 'class' => 'form-control','placeholder' => 'Seleccione el artículo...']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin serial textfield -->
        <div class="form-group">
            {!! Form::label('serial', 'Serial:') !!}
            {!! Form::text('serial', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
        </div>
<!-- End serial textfield -->

<!-- Begin destination_id select -->
        <div class="form-group">
            {!! Form::label('destination_id', 'Almacén de Destino:') !!}
            {!! Form::select('destination_id', $warehouseList, null, ['class' => 'form-control','placeholder' => 'Seleccione el destino...']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin status_id textfield -->

            {!! Form::hidden('status_id', 2) !!}
            {!! Form::hidden('user_id', Auth::user()->id) !!}

<!-- End status_id textfield -->

<!-- Begin Submit button -->
    <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>
<!-- End Submit Button -->