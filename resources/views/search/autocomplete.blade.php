
{!! Form::open(['action' => ['SearchController@autocomplete'], 'method' => 'GET']) !!}
<div class="col-sm-4">
    {!! Form::text('q', '', ['id' =>  'q','class'=>'form-control', 'placeholder' =>  'Buscar...']) !!}
</div>
<div class="col-sm-1">
    <a class="btn btn-default" href="" id="btnDetalle" disabled="disabled">Ver detalle</a>
</div>
{!! Form::close() !!}
