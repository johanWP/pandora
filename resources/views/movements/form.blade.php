<div class="row">
    <div class="alert alert-danger" id="divMsg" style="display: none"></div>
</div>
<div class="row">
    <!-- Begin Company textfield -->
    <div class="form-group">

        {!! Form::label('company', 'Empresas:') !!}
        {!! Form::text('company', Auth::user()->currentCompany->name, ['class' => 'form-control', 'readonly']) !!}

    </div>
    <!-- End Company textfield -->
</div>

<!-- Begin activity textfield -->
<div class="row">
    <div class="col-sm-12" id="divActivity">
        <label>Actividad:</label>
        <br/>
        @foreach($activities as $activity)
            <label class="radio-inline">
              <input type="radio" name="rdActivity" id="activity_{{ $activity->id }}" value="{{ $activity->id }}">
              {{ $activity->name }}
            </label>

        @endforeach

    </div>
</div>
<hr />
<!-- End activity textfield -->
<!-- Begin remito textfield -->
        <div class="form-group">
            {!! Form::label('remito', 'Remito:') !!}
            {!! Form::text('remito', null, ['class' => 'form-control', 'placeholder' => 'Opcional', 'id'=>'remito']) !!}
        </div>
<!-- End remito textfield -->
<!-- Begin origin_id select -->
        <div class="form-group">
            {!! Form::label('origin_id', 'Almacén de Origen:') !!}
            {!! Form::select('origin_id', [], null, ['class' => 'form-control','placeholder' => 'Seleccione el origen...', 'id'=>'origin_id']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin destination_id select -->
        <div class="form-group">
            {!! Form::label('destination_id', 'Almacén de Destino:') !!}
            {!! Form::select('destination_id', [], null, ['class' => 'form-control','placeholder' => 'Seleccione el destino...']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin ticket textfield -->
        <div class="form-group">
            {!! Form::label('ticket', 'Ticket:') !!}
            {!! Form::text('ticket', null, ['class' => 'form-control']) !!}
        </div>
<!-- End ticket textfield -->
<div id="divArticles">{{--COMIENZA PANEL DE ARTICULO--}}
<div class="panel panel-default" id="divArticlePanel1">
    <div class="panel-body">

<!-- Begin article_id select -->
        <div class="form-group">
            {!! Form::label('article_id1', 'Artículo:') !!}
            {!! Form::select('article_id1', ['' => 'Seleccione el artículo...'], null, ['id'=>'article_id1', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
<!-- End origin_id select -->

<!-- Begin quantity textfield -->
        <div class="form-group">
            {!! Form::label('quantity1', 'Cantidad:') !!}
            <p id="cantidad" class="help-block">Cantidad Disponible: <span  id="maxQ1"></span></p>
            {!! Form::number('quantity1', null, ['class' => 'form-control', 'id' =>'quantity1']) !!}
        </div>
<!-- End quantity textfield -->

<!-- Begin serial textfield -->
        <div class="form-group">
            {!! Form::label('serial1', 'Serial:', ['id'=>'serialLabel1']) !!}
            {!! Form::text('serial1', null, ['class' => 'form-control', 'id'=>'serial1']) !!}
        </div>
<!-- End serial textfield -->

<!-- Begin serial select -->
        <div class="form-group">
            {!! Form::label('serialListLabel1', 'Serial:', ['id'=>'serialListLabel1']) !!}
            {!! Form::select('serialList1', [], null, ['id'=>'serialList1','class' => 'form-control','placeholder' => 'Seleccione...']) !!}
        </div>
<!-- End serial select -->
        <button class="btn btn-default" type="button" id="btnAddPanel1" name="btnAddPanel1">Agregar Otro Artículo</button>
    </div>
</div>
{{--FIN DEL PANEL DE ARTICULO--}}
</div>
<!-- Begin note textfield -->
        <div class="form-group">
            {!! Form::label('note', 'Notas / Observaciones:') !!}
            {!! Form::text('note', null, ['class' => 'form-control', 'placeholder' => 'Opcional']) !!}
        </div>
<!-- End note textfield -->
{!! Form::text('numArticles', null, ['class' => 'form-control', 'id' => 'numArticles']) !!}
<!-- Begin Submit button -->
    <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control', 'id'=>'btnSubmit']) !!}
    </div>
<!-- End Submit Button -->