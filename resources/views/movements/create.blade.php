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
        var warehouses;
        var inventario;
        var origin_type;
        $( document ).ready(function()
        {
            var articleCount =1;
            $('#serial1').hide();
            $('#serialList1').hide();
            $('#serialLabel1').hide();
            $('#serialListLabel1').hide();
            $('#divMsg').hide();
            var rdActivity = $("#frm input[type='radio'][name='rdActivity']");
            var companyList =  $('#companyList');
            var company_id = $('#company_id').val();
            var activity_id;
            var count = rdActivity.length;

            if(count == 1 )
            {
                $("#frm input[type='radio'][name='rdActivity']:first").attr('checked', true);
                activity_id = $("#frm input[type='radio'][name='rdActivity']:checked").val();
                loadWarehouses(company_id, activity_id);
            }

            $("#frm input[type='radio'][name='rdActivity']").change(function()
            {
                activity_id = $("#frm input[type='radio'][name='rdActivity']:checked").val();
                  loadWarehouses(company_id, activity_id);
            });

            $('#origin_id').change(function()
            {
                removeAllPanels();
                $('#maxQ1').html('');
                $('#frm div').removeClass('has-error');
                var origin_id = $(this).val();
                for (var i in warehouses)
                {
                    // busco los detalles del warehouse seleccionado en una variable que guardé en el ajax request
                    if(warehouses[i].id == origin_id)
                    {
                        origin_type= warehouses[i].type_id;
                    }
                }
                      $('#serialLabel1').hide();
                      $('#serial1').hide();
                      $('#serialListLabel1').hide();
                      $('#serialList1').hide();
                      $('#quantity1').val('')
                                 .attr('readonly', false);

                var request = $.ajax({
                  url: "/api/inventory/" + origin_id,
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
                    $('#article_id1').empty()
                                    .append($('<option>')
                                    .text('Seleccione el artículo...')
                                    .attr('value', ''))
                                    .append(favArticles)
                                    .append(allArticles)
                                    .attr('disabled', false);

//                    var sel = $('#origin_id').val();

                }); /* Fin del .done */

                request.fail(function( jqXHR, textStatus ) {
                  alert( "Fallo cargando los articulos: " + textStatus );
                });

            }); /* Fin del .change() */


            $('#article_id1').change(showSerialText);
            $('#btnAddPanel1').click(function()
            {
                var numItems = $('.panel').length +1;
                addPanel();
                $(this).attr('disabled', 'disabled')
            });

            $('#btnSubmit').click(function(event)
            {
                var numPanels = $('.panel').length;
                event.preventDefault();
                $('#numArticles').val(numPanels);
                valid = validate();
                if (valid)
                {
                    $('#frm').submit();
                }
            });
            sortDropDownListByText('origin_id');
            sortDropDownListByText('destination_id');
        });  // Fin del document.ready()

        function validate()
        {
            var valid = true; var i=1;
            var valorActual =''; var mensaje ='';
            var valorSiguiente;
            var numPanels = $('.panel').length;
            $('#frm div').removeClass('has-error');
            $('#divMsg').html('').hide();

//  VALIDO QUE NO HAYA ARTICULOS REPETIDOS
/*

            if(numPanels >1)
            {
                for(i=1; i < numPanels; i++)
                {
                    valorActual = $('#article_id'+i).val();
                    for (j=i+1; j < numPanels; j++)
                    {

                            valorSiguiente = $('#article_id'+j).val();
                            if (valorActual == valorSiguiente)
                            {
                                $('#divArticlePanel'+i).addClass('has-error');
                                $('#divArticlePanel'+j).addClass('has-error');
                                valid = false;
                                mensaje = mensaje + 'Los articulos '+i+' y '+j+' son iguales. <br />';
                                $('#divMsg').html(mensaje).slideDown('slow');
                            }

                    }
                }
            }

*/
//  VALIDO QUE TODOS LOS ARTICULOS TENGAN UNA CANTIDAD
            for (i=1; i<= numPanels; i++)
            {
                cantidad = $('#quantity'+i).val();
                if (cantidad=='' || cantidad==0)
                {
                    $('#divArticlePanel'+i).addClass('has-error');
                    valid= false;
                    mensaje = mensaje + 'Todos los articulos deben tener una cantidad especificada. <br />';
                    $('#divMsg').html(mensaje).slideDown('slow');
                }
            }
            return  valid;
        }

        function sortDropDownListByText(selectId)
        {
          var foption = $('#'+ selectId + ' option:first');
          var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b)
            {
               return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
            });
            $('#' + selectId).html(soptions).prepend(foption);

        };

        function loadWarehouses(company, activity)
        {
                var request = $.ajax({
                  url: "/api/warehousesByActivity/",
                  data: {company_id: company, rdActivity: activity},
                  method: "GET",
                  dataType: "json"
                });

                request.done(function( result )
                {
                warehouses = result;

                    $('#origin_id').empty()
                                    .append($('<option>')
                                    .text('Seleccione el origen...')
                                    .attr('value', ''));
                    for(var k in result)
                    {
                        if(result[k].active==1)
                        {
                            $('#origin_id').append($('<option>')
                                        .text(result[k].name)
                                        .attr('value', result[k].id));
                        }
                    }

                    $('#destination_id').empty()
                                    .append($('<option>')
                                    .text('Seleccione el destino...')
                                    .attr('value', ''));
                    for(var k in result) {
                        if(result[k].active==1) {
                            $('#destination_id').append($('<option>')
                                    .text(result[k].name)
                                    .attr('value', result[k].id));
                        }
                    }

                });

                request.fail(function( jqXHR, textStatus )
                {
                    alert( "Error al cargar los almacenes: " + textStatus );
                });


        }


        function addPanel()
        {
            var i = $('.panel').length +1;
            var j = i -1;
            var panelHTML = '<div class="panel panel-default" id="divArticlePanel'+ i +'"><div class="panel-body">' +
                    '<div class="form-group">' +
                        '<label for="article_id'+ i +'">Artículo:</label>' +
                        '<select id="article_id'+ i +'" class="form-control" name="article_id'+ i +'"></select>' +
                    '</div>' +
                        '<div class="form-group"><label for="quantity">Cantidad:</label>' +
                        '<p id="cantidad'+ i +'" class="help-block">Cantidad Disponible: <span  id="maxQ'+ i +'"></span></p>' +
                        '<input class="form-control" id="quantity'+ i +'" name="quantity'+ i +'" type="number">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="serial'+ i +'" id="serialLabel'+ i +'" style="display: none">MAC:</label>' +
                        '<input class="form-control" id="serial'+ i +'" name="serial'+ i +'" type="text" style="display: none;">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="serialListLabel'+ i +'" id="serialListLabel'+ i +'" style="display: none">MAC:</label>' +
                        '<select id="serialList'+ i +'" class="form-control" name="serialList'+ i +'" style="display: none;"></select>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="note'+ i +'" id="noteLabel'+ i +'">Nota:</label>' +
                        '<input class="form-control" placeholder="Opcional" name="note'+i+'" type="text" id="note'+i+'">' +
                    '</div>' +
                    '<button class="btn btn-default" type="button" id="btnAddPanel'+ i +'" name="btn'+ i +'">Agregar Otro Artículo</button> ' +
                    ' <button class="btn btn-danger" type="button" id="btnRemovePanel'+ i +'" name="btnRemove'+ i +'">Eliminar</button>'+
                    '</div>' +
                    '</div>';
            $('#divArticles').append(panelHTML);
            $(this).attr('disabled', 'disabled');
            $('#btnRemovePanel'+j).attr('disabled', 'disabled');
            $('.btn-default').on('click',addPanel);
            $('.btn-danger').on('click',removePanel);
            loadArticles(inventario, 'article_id'+i);

            $('#article_id'+i).on('change', showSerialText);
        }

        function removePanel()
        {
            var i;
            $(this).closest('.panel').remove();
            i = $('.panel').length
            $('#btnAddPanel'+i).attr('disabled', false);
            $('#btnRemovePanel'+i).attr('disabled', false);
        }

        function loadArticles(result, dropdown)
        {
            var allArticles = $('<optgroup>');
            allArticles.attr('label', 'Todos los Artículos');
            var favArticles = $('<optgroup>');
            favArticles.attr('label', 'Favoritos');

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
            $('#'+dropdown).empty()
                    .append($('<option>')
                            .text('Seleccione el artículo...')
                            .attr('value', ''))
                    .append(favArticles)
                    .append(allArticles)
                    .attr('disabled', false);
        }

/*
     Decide si mostrar textbox o dropdown en caso de que el articulo sea serializable
*/
        function showSerialText()
        {
            var cant =0;
            var serializable = 0;
            var selected_id = $(this).val();
            var serial;
            var panelCount = $('.panel').length;
            for (var i in inventario)
            {
                if (inventario[i].id == selected_id)
                {
                    serializable = inventario[i].serializable;
                    cant = inventario[i].cantidad;
                    if(serializable=='1')
                    {
                        $('#quantity'+panelCount).val('1')
                                .attr('readonly', true);

                        if (origin_type != '1') // el articulo es serializable y el almacen _NO_ es de sistema
                        {
                            $('#serialList'+panelCount).empty()
                                    .append($('<option>')
                                            .text('Seleccione...')
                                            .attr('value', ''));

                            for (j in inventario[i].seriales)
                            {
                                serial = inventario[i].seriales[j].serial;
                                $('#serialList'+panelCount).append($('<option>')
                                        .text(serial)
                                        .attr('value', serial));
                            }
                            $('#serialListLabel'+panelCount).show();
                            $('#serialList'+panelCount).show();

                        } else // el articulo es serializable y el almacen es de sistema
                        {
                            $('#serialLabel'+panelCount).show();
                            $('#serial'+panelCount).show();
                        }
                    } else  // el articulo no es serializable
                    {
                        $('#serialLabel'+panelCount).hide();
                        $('#serial'+panelCount).hide();
                        $('#serialListLabel'+panelCount).hide();
                        $('#serialList'+panelCount).hide();
                        $('#quantity'+panelCount).val('')
                                .attr('readonly', false);
                    }
                }
            }
            $('#maxQ'+panelCount).html(cant);

        }
/*
*   Borra todos los panels para agregar articulos excepto el original
* */
        function removeAllPanels()
        {
            var panelCount = $('.panel').length;

            if(panelCount>1)
            {
                for (i=2; i <= panelCount; i++)
                {
                    $('#divArticlePanel'+i).remove();
                }
            }
        }
    </script>
@endsection
