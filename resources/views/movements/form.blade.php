<div class="row">
    <!-- Begin Company textfield -->
    <div class="form-group">

    {!! Form::label('companyList', 'Empresas:') !!}
    @if(Auth::user()->company->parent==0)
{{--Si el usuario no es de una empresa parente, le preselecciono la empresa--}}

        {!! Form::text('company', Auth::user()->company->name, ['class' => 'form-control', 'readonly']) !!}
        {!! Form::hidden('companyList', Auth::user()->company->id) !!}
    @else
{{--Si el usuario es de una empresa parent, le muestro un dropdown para seleccionar la empresa--}}
        {!! Form::select('companyList[]', $companies , null, ['class' => 'form-control', 'id'=>'companyList', 'placeholder'=>'Seleccione...']) !!}
    @endif

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

<!-- Begin article_id select -->
        <div class="form-group">
            {!! Form::label('article_id', 'Artículo:') !!}
            {!! Form::select('article_id', ['' => 'Seleccione el artículo...'], null, ['id'=>'article_id', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
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

<!-- Begin serial select -->
        <div class="form-group">
            {!! Form::label('serialListLabel', 'Serial:', ['id'=>'serialListLabel']) !!}
            {!! Form::select('serialList', [], null, ['id'=>'serialList','class' => 'form-control','placeholder' => 'Seleccione...']) !!}
        </div>
<!-- End serial select -->

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