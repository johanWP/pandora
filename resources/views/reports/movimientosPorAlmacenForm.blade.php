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
{{--  <div class=""><br/>
    <a class="btn btn-primary" href="#"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>--}}
</div>

    <hr/>

  {!! Form::open(['url' => '/reportes/movimientosPorAlmacen', 'id' => 'frm']) !!}
<div class="row">
    <!-- Begin Company textfield -->
    <div class="form-group">

    {!! Form::label('companyList', 'Empresas:') !!}
    @if(Auth::user()->company->parent==1)

{{--Si el usuario es de una empresa parent, le muestro un dropdown para seleccionar la empresa--}}
        {!! Form::select('companyList[]', $companies , null, ['class' => 'form-control', 'id'=>'companyList', 'placeholder'=>'Seleccione...']) !!}
    @else
{{--Si el usuario no es de una empresa parente, le preselecciono la empresa--}}

        {!! Form::text('company', Auth::user()->company->name, ['class' => 'form-control', 'readonly']) !!}
        {!! Form::hidden('companyList', Auth::user()->company->id) !!}
    @endif

    </div>
    <!-- End Company textfield -->
</div>


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
<div class="row">
        <div class="col-sm-12">
            <div class="form-group" id="divOrigin">
                 {!! Form::label('warehouseOrigin', 'Almacén de Origen:') !!}<br/>

                 <label class="radio-inline">
                    <input type="radio" name="rdOrigin" id="rdOriginAll" value="all" checked disabled>
                    Todos los almacenes
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="rdOrigin" id="rdOriginOne" value="one" disabled>
                    Seleccione un almacén
                  </label>
                <!-- Begin origin textfield -->

                <br/><br/>
                <select id="origin" name="origin" class="form-control" disabled>
                    <option>Seleccione...</option>
                </select>
            </div>
            <!-- End origin textfield -->
        </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12">
            <div class="form-group" id="divDestination">
                 {!! Form::label('warehouseDestination', 'Almacén de Destino:') !!}<br/>

                 <label class="radio-inline">
                    <input type="radio" name="rdDestination" id="rdDestinationAll" value="all" checked disabled>
                    Todos los almacenes
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="rdDestination" id="rdDestinationOne" value="one" disabled>
                    Seleccione un almacén
                  </label>
                <!-- Begin origin textfield -->

                <br/><br/>
                <select id="destination" name="destination" class="form-control" disabled>
                    <option>Seleccione...</option>
                </select>
            </div>
            <!-- End origin textfield -->
    </div>
</div>
<hr/>
<div class="row">
    <!-- Begin fechaDesde textfield -->
    <div class='col-sm-6' id="divFechaDesde">
        <label>Desde:</label>
        <div class="form-group">
            <div class='input-group date'>
                <input type='text' class="form-control"  id='fechaDesde' name='fechaDesde' readonly />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <!-- End fechaDesde textfield -->
    <!-- Begin fechaHasta textfield -->
    <div class='col-sm-6' id="divFechaHasta">
        <label>Hasta:</label>
        <div class="form-group">
            <div class='input-group date'>
                <input type='text' class="form-control"  id='fechaHasta' name='fechaHasta' readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <!-- End fechaHasta textfield -->
</div>

<div class="row">
    <div class="form-group col-sm-12">
        <input class="btn btn-primary col-sm-12" type="button" id="btnValidate" name="btnValidate" value="Ver">
    </div>
</div>

{!! Form::close() !!}
@endsection

@section('scripts')

  <script src="/js/jquery-ui.min.js"></script>
  <script src="/js/datepicker-es.js"></script>

  <script type="text/javascript">
    $(function () {
        $('#frm input[name="rdActivity"]').click(function()
        {
            $('#frm input[type="radio"]').attr('disabled', false);
//            $('#frm input[name="rdDestination"]').attr('disabled', false);
        });
        $('#fechaHasta').datepicker({ maxDate: 'today'})
                    .change(function()
                    {
                        var maxDate = $(this).val();
                        $( "#fechaDesde" ).datepicker( "option", "maxDate", maxDate);
                    });
        $('#fechaDesde').datepicker({ maxDate: 'today'})
                    .change(function()
                    {
                        var minDate = $(this).val();
                        $( "#fechaHasta" ).datepicker( "option", "minDate", minDate);
                    });

        $('#frm input[name="rdActivity"]').change(function()
        {
//                Lleno el dropdown de almacén de origen cuando se selecciona la actividad
            var activity_id = $("#frm input[name='rdActivity']:checked").val();
            var company_id = $("#companyList").val();
            $('#origin').empty()
                        .append($('<option>')
                        .text('Seleccione...')
                        .attr('value', ''));

            var origin = $.ajax({
              url: "/api/warehousesByActivity/",
              data: {company_id: company_id, rdActivity: activity_id},
              method: "GET",
              dataType: "json"
            });

            origin.done(function( result )
            {
                for(var k in result)
                {
                    $('#origin').append($('<option>')
                                .text(result[k].name)
                                .attr('value', result[k].id));
                    $('#destination').append($('<option>')
                                .text(result[k].name)
                                .attr('value', result[k].id));
                } /* Fin del for */


                sortDropDownListByText('destination_id');
//                $('#origin').attr('disabled', false);
//                $('#destination').attr('disabled', false);

            });/* Fin del .done */



            origin.fail(function( jqXHR, textStatus ) {
                alert( "Fallo cargando los almacenes de origen " + textStatus );
            });
        }); // fin del form input[type=radio]

        $('form input[name="rdDestination"]').change(function(){
            $('#destination').prop('disabled', function(i, v) { return !v; });

        });
        $('form input[name="rdOrigin"]').change(function(){
            $('#origin').prop('disabled', function(i, v) { return !v; })
                        .removeClass('has-error');
        });
        var frm = $('#frm');

        $('#btnValidate').click(function()
        {
            valid = validate();
            if(valid)
            {
              frm.submit();
            }
        });

    });  // fin del document.ready()

    function validate()
    {
        var valid = true;

        $('#frm div').removeClass('has-error');

// Hay actividad seleccionada?
        var rdActivity = $("input[type='radio'][name='rdActivity']:checked").val();
        if((typeof rdActivity)=== 'undefined')
        {
          $('#divActivity').addClass('has-error');
          valid = false;
        }
// Almacen de origen
        var rdOrigin = $("input[name='rdOrigin']:checked").val();
        if((rdOrigin=='one') && ($('#origin').val()==='Seleccione...' || $('#origin').val()==='') )
        {
            $('#divOrigin').addClass('has-error');
            valid = false;
        }

// Almacen Destino
        var rdDestination = $("input[name='rdDestination']:checked").val();
        if((rdDestination=='one') && ($('#destination').val()==='Seleccione...' || ($('#destination').val()==='') ))
        {
            $('#divDestination').addClass('has-error');
            valid = false;
        }
// Fecha Desde
        var fechaDesde = $('#fechaDesde').val();
        if(fechaDesde=='')
        {
            $('#divFechaDesde').addClass('has-error');
            valid=false;
        }
// Fecha Hasta
        var fechaHasta = $('#fechaHasta').val();
        if(fechaHasta=='')
        {
            $('#divFechaHasta').addClass('has-error');
            valid=false;
        }

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