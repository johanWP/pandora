@extends('master')

@section('title')
    Movimientos por Almacén
@endsection

@section('css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Movimientos por Almacén</h1>
        </div>
    </div>

    <hr/>

    {!! Form::open(['action' => ['SearchController@autocompleteBuscarEquipo'], 'method' => 'GET']) !!}
    <div class="row">
        <div class="col-sm-12" id="divActivity">
            {!! Form::label('serial', 'MAC:') !!}
            {!! Form::text('serial', null, ['class' => 'form-control', 'placeholder' => 'Escriba la MAC...', 'id'=>'serial']) !!}
        </div>
    </div>
    {!! Form::close() !!}
<br />
    <div class="row">
        <div class="form-group col-sm-12">
            <a class="btn btn-primary" id="btnVer" disabled="disabled">Buscar Equipo</a>
        </div>
    </div>


@endsection

@section('scripts')

    <script src="/js/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $( "#serial" ).autocomplete(
                    {
                        source: "/search/autocompleteBuscarEquipo",
                        minLength: 3,
                        select: function(event, ui)
                        {
                            $('#serial').val(ui.item.value);
                            $('#btnVer').attr('href','/reportes/buscarEquipo/'+ ui.item.value)
                                    .attr('disabled', false);
                        }  // fin del select
                    });     // fin del $( "#q" ).autocomplete
        });  // fin del document.ready()

        function validate()
        {
            var valid = true;

            $('#frm div').removeClass('has-error');


            return valid;
        } // fin de validate

        function sortDropDownListByText(selectId) {
            var foption = $('#'+ selectId + ' option:first');
            var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b) {
                return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
            });
            $('#' + selectId).html(soptions).prepend(foption);

        };

    </script>
@endsection