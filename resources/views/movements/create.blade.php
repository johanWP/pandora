@extends('master')

@section('title')
Nuevo Movimiento
@endsection

@section('content')
    <h1>Nuevo Movimiento</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::open(['url' => 'movimientos', 'id'=>'frm']) !!}
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
            $('#serial').hide();
            $('#serialLabel').hide();
            $("#frm input[type='radio'][name='rdActivity']").change(function()
            {

//                var activity_id = ;
                var activity_id = "";
                var rdActivity = $("input[type='radio'][name='rdActivity']:checked");
                if (rdActivity.length > 0) {
                    activity_id = rdActivity.val();
                }

                var company_id = $('#companyList').val();
                if(company_id != '')
                {
                    var request = $.ajax({
                      url: "/api/warehousesByActivity/",
                      data: {company_id: company_id, rdActivity: activity_id},
                      method: "GET",
                      dataType: "json"
                    });

                    request.done(function( result ) {
                        $('#origin_id').empty()
                                        .append($('<option>')
                                        .text('Seleccione el artículo...')
                                        .attr('value', ''));
                        for(var k in result) {
                            $('#origin_id').append($('<option>')
                                            .text(result[k].name)
                                            .attr('value', result[k].id));
                        }

                        $('#destination_id').empty()
                                        .append($('<option>')
                                        .text('Seleccione el artículo...')
                                        .attr('value', ''));
                        for(var k in result) {
                            $('#destination_id').append($('<option>')
                                            .text(result[k].name)
                                            .attr('value', result[k].id));
                        }

                    });

                    request.fail(function( jqXHR, textStatus ) {
                        alert( "Error al cargar los almacenes: " + textStatus );
                    });
                }

            });

            $('#origin_id').change(function()
            {

                var $warehouse_id = $(this).val();
                var request = $.ajax({
                  url: "/api/inventory/" + $warehouse_id,
                  method: "GET",
                  dataType: "json"
                });

                request.done(function( result ) {
                    var allArticles = $('<optgroup>');
                    allArticles.attr('label', 'Todos los Artículos');
                    var favArticles = $('<optgroup>');
                    favArticles.attr('label', 'Favoritos');

                    inventario = result;
                    for(var k in result) {
                        allArticles.append($('<option>')
                                        .text(result[k].name)
                                        .attr('value', result[k].id));
                        if (result[k].fav ==1)
                        {
                            favArticles.append($('<option>')
                                        .text(result[k].name)
                                        .attr('value', result[k].id));
                        }
                    }
                    $('#article_id').empty()
                                    .append($('<option>')
                                    .text('Seleccione el artículo...')
                                    .attr('value', ''))
                                    .append(favArticles)
                                    .append(allArticles);

                    var sel = $('#origin_id').val();

                }); /* Fin del .done */

                request.fail(function( jqXHR, textStatus ) {
                  alert( "Fallo cargando los articulos: " + textStatus );
                });
//   *********************
/*
            $('#destination_id').empty()
                            .append($('<option>')
                            .text('Seleccione el destino...')
                            .attr('value', ''));
            var destination = $.ajax({
              url: "/api/warehouseDetail/" + $(this).val(),
              method: "GET",
              dataType: "json"
            });

            destination.done(function( result ) {
                getDestinationWarehouseList(result.activity_id)
            });

            destination.fail(function( jqXHR, textStatus ) {
                alert( "Fallo cargando detalles del almacén de origen: " + textStatus );
            });

*/
/*******/
            }); /* Fin del .change() */
            $('#article_id').change(function (){
                var cant = inventario[this.value].cantidad;
                var serializable = inventario[this.value].serializable;
                $('#maxQ').html(cant);
                if(serializable=='0')
                {
                    $('serialLabel').hide();
                    $('serial').hide();
                } else
                {
                    $('#serialLabel').show();
                    $('#serial').show();
                }
            });
            sortDropDownListByText('origin_id');
            sortDropDownListByText('destination_id');
        });  // Fin del document.ready()

        function validate() {}

        function getDestinationWarehouseList(activity_id)
        {
            var destination = $.ajax({
              url: "/api/warehousesByActivity/"+activity_id,
              method: "GET",
              dataType: "json"
            });

            destination.done(function( result ) {
                for(var k in result)
                {
                    $('#destination_id').append($('<option>')
                                    .text(result[k].name)
                                    .attr('value', result[k].id));
                } /* Fin del for */
                sortDropDownListByText('destination_id');
            });

            destination.fail(function( jqXHR, textStatus ) {
              alert( "Fallo cargando los almacenes de destino: " + textStatus );
            });
        }

        function sortDropDownListByText(selectId) {
          var foption = $('#'+ selectId + ' option:first');
          var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b)
            {
               return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
            });
            $('#' + selectId).html(soptions).prepend(foption);

        };

    </script>
@endsection
