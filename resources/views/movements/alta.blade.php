@extends('master')

@section('title')
Ingreso de Artículos
@endsection

@section('content')
    <h1>Ingreso de Artículos</h1>
    <hr/>
    <!--  Incluir el parcial que lista los errores -->

    @include('errors.list')

    {!! Form::open(['url' => 'movimientos', 'id' => 'frm']) !!}
    @include('movements.form', ['submitButtonText' => 'Registrar Ingreso de Productos'])

    {!! Form::close() !!}

@endsection

@section('scripts')

    <script>

        $( document ).ready(function()
        {
            @if (Auth::user()->securityLevel < 20)
                $('h1').html('Recuperación de Equipos');
            @endif

            $('#serialLabel').hide();
            $('#serial').hide();
            $('#cantidad').hide();
            var warehouses;
            $("#frm input[type='radio'][name='rdActivity']").change(function()
            {
                loadDestination_id();
                var activity_id = "";
                var rdActivity = $("input[type='radio'][name='rdActivity']:checked");
                if (rdActivity.length > 0) {
                    activity_id = rdActivity.val();
                }
                var company_id = $('#companyList').val();
                //        Cargar los almacenes unicamente de sistemas en el dropdown de origen
                if (company_id !='')
                {
                    var origin = $.ajax({

                        url: "/api/warehousesByType",
                        data: {company_id: company_id, rdActivity: activity_id, type_id: '1'},
                        method: "GET",
                        dataType: "json"
                    });

                    origin.done(function (result)
                    {
                        warehouses = result;
                        $('#origin_id').empty()
                                .append($('<option>')
                                        .text('Seleccione el origen...')
                                        .attr('value', ''));
                        for (var k in result) {
                            $('#origin_id').append($('<option>')
                                    .text(result[k].name)
                                    .attr('value', result[k].id));
                        }

                    });  //  Fin del request.done

                    origin.fail(function (jqXHR, textStatus)
                    {
                        alert("Fallo cargando los almacenes de origen: " + textStatus);
                    }); // Fin del request.fail


                }

            });

            var inventario;
            $('#origin_id').change(function()
            {
                var $warehouse_id = $(this).val();
                var request = $.ajax({
                  url: "/api/inventory/" + $warehouse_id,
                  method: "GET",
                  dataType: "json"
                });

                request.done(function( result )
                {
                    var allArticles = $('<optgroup>');
                    allArticles.attr('label', 'Todos los Artículos');
                    var favArticles = $('<optgroup>');
                    favArticles.attr('label', 'Favoritos');

                    inventario = result;
                    for(var k in result)
                    {
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
                                    .append(allArticles).
                                    attr('disabled', false);

                    var sel = $('#origin_id').val();
                    var selectedWarehouse = warehouses[sel];
//                    sortDropDownListByText('article_id');
                }); /* Fin del .done */

                request.fail(function( jqXHR, textStatus ) {
                  alert( "Fallo cargando los articulos: " + textStatus );
                });


            }); /* Fin del .change() */

            $('#article_id').change(function (){

                var text = $('#article_id option:selected').text();
                var selected_id = $(this).val();
//                if(inventario[text].serializable == 1)
                if(inventario[selected_id].serializable == 1)
                {
                    $('#serialLabel').show();
                    $('#serial').show();
                    $('#quantity').val('1')
                                .attr('readonly', true);
                } else
                {
                     $('#serialLabel').hide();
                     $('#serial').hide();
                     $('#quantity').val('')
                                .attr('readonly', false);
                }

            });

            sortDropDownListByText('destination_id');
        });  // Fin del document.ready()

function sortDropDownListByText(selectId) {
    var foption = $('#'+ selectId + ' option:first');
    var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b) {
       return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
    });
    $('#' + selectId).html(soptions).prepend(foption);

};

function loadDestination_id()
{

    $('#destination_id').empty()
                    .append($('<option>')
                    .text('Seleccione el destino...')
                    .attr('value', ''));

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
            alert( "Error al cargar los almacenes destino: " + textStatus );
        });
    }
 }

    </script>
@endsection