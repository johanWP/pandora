<!-- Begin remito textfield -->
        <div class="form-group">
            {!! Form::label('remito', 'Remito:') !!}
            {!! Form::text('remito', null, ['class' => 'form-control', 'placeholder' => 'Opcional', 'id'=>'remito']) !!}
        </div>
<!-- End remito textfield -->
<!-- Begin origin_id select -->
        <div class="form-group">
            {!! Form::label('origin_id', 'Almacén de Origen:') !!}
            {!! Form::select('origin_id', $warehouseList, null, ['class' => 'form-control','placeholder' => 'Seleccione el origen...', 'id'=>'origin_id']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin article_id select -->
        <div class="form-group">
            {!! Form::label('article_id', 'Artículo:') !!}
            {!! Form::select('article_id', ['' => 'Seleccione el artículo...'], null, ['id'=>'article_id', 'class' => 'form-control']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin quantity textfield -->
        <div class="form-group">
            {!! Form::label('quantity', 'Cantidad:') !!}
            <p id="cantidad" class="help-block">Cantidad Disponible: <span  id="maxQ"></span></p>
            {!! Form::number('quantity', null, ['class' => 'form-control', 'id' =>'quantity']) !!}
        </div>
<!-- End quantity textfield -->

<!-- Begin serial textfield -->
        <div class="form-group">
            {!! Form::label('serial', 'Serial:', ['id'=>'serialLabel']) !!}
            {!! Form::text('serial', null, ['class' => 'form-control', 'id'=>'serial']) !!}
        </div>
<!-- End serial textfield -->

<!-- Begin destination_id select -->
        <div class="form-group">
            {!! Form::label('destination_id', 'Almacén de Destino:') !!}
            {!! Form::select('destination_id', $warehouseList, null, ['class' => 'form-control','placeholder' => 'Seleccione el destino...']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin ticket textfield -->
        <div class="form-group">
            {!! Form::label('ticket', 'Ticket:') !!}
            {!! Form::text('ticket', null, ['class' => 'form-control']) !!}
        </div>
<!-- End ticket textfield -->

<!-- Begin note textfield -->
        <div class="form-group">
            {!! Form::label('note', 'Notas / Observaciones:') !!}
            {!! Form::text('note', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
        </div>
<!-- End note textfield -->

<!-- Begin Submit button -->
    <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>
<!-- End Submit Button -->