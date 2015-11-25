@extends('master')

@section('title')
Nuevo Movimiento
@endsection

@section('content')
    <h1>Nuevo Movimiento</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::open(['url' => 'movimientos']) !!}
    @include('movements.form', ['submitButtonText' => 'Registrar nuevo movimiento'])

    {!! Form::close() !!}

@endsection

@section('scripts')
{{--    <link rel="stylesheet" href="jquery-ui.min.css">
    <script src="external/jquery/jquery.js"></script>
    <script src="jquery-ui.min.js"></script>--}}
    <script>
        $( document ).ready(function()
        {
            var inventario;
            $('#origin_id').change(function()
            {
                var $warehouse_id = $(this).val()
                var request = $.ajax({
                  url: "/api/articlesList/" + $warehouse_id,
                  method: "GET",
                  dataType: "json"
                });

                request.done(function( result ) {
                    $('#article_id').empty()
                                    .append($('<option>')
                                    .text('Seleccione al artículo...')
                                    .attr('value', ''));
                    for(var k in result) {
                        inventario = result;
                        //console.log (Object.keys(result[k])[0]);
                        $('#article_id').append($('<option>')
                                        .text(Object.keys(result[k])[0])
                                        .attr('value', k));
                    }
                });

                request.fail(function( jqXHR, textStatus ) {
                  alert( "Request failed: " + textStatus );
                });

            });

            $('#article_id').change(function (){

                var cant = inventario[this.value][$("#article_id option:selected").text()];
                $('#maxQ').html(cant);
            });
        });  // Fin del document.ready()

    </script>
@endsection
