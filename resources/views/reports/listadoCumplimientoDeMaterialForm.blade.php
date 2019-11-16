@extends('master')

@section('title')
    Listado de Cumplimiento de Material
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Listado de Cumplimiento de Material</h1>
  </div>
{{--  <div class=""><br/>
    <a class="btn btn-primary" href="#"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>--}}
</div>

    <hr/>

  {!! Form::open(['url' => 'reportes/listadoCumplimientoDeMaterial']) !!}
  <div class="row">
    <!-- Begin  textfield -->
    <div class="form-group">
    @if(Auth::user()->company->parent==false)
        {!! Form::label('companyList', 'Empresas:') !!}
        {!! Form::select('companyList[]', $companies , null, ['class' => 'form-control', 'multiple', 'id'=>'companyList']) !!}
    @else
        {!! Form::label('company', 'Empresa:') !!}
        {!! Form::text('company', Auth::user()->company->name, ['class' => 'form-control', 'readonly']) !!}
        {!! Form::hidden('companyList', Auth::user()->company->id) !!}
    @endif
    </div>
    <!-- End  textfield -->
  </div>
  <div class="row">
    <!-- Begin  textfield -->
    <div class="form-group">
        {!! Form::label('articleList', 'Artículos:') !!}
        {!! Form::select('articleList[]', $articles , null, ['class' => 'form-control', 'multiple', 'id'=>'articleList']) !!}
    </div>
    <!-- End  textfield -->
  </div>
  <div class="row">
    <h4>Actividad:</h4>
    @foreach($activities as $activity)
        <label class="radio-inline">
          <input type="radio" name="activity" id="activity_{{ $activity->id }}" value="{{ $activity->id }}"> {{ $activity->name }}
        </label>

    @endforeach
  </div>
  <br/>
  <div class="row">
    <!-- Begin  textfield -->
    <div class="form-group">
        {!! Form::label('warehouseOrigin', 'Almacen de Origen:') !!}
        <select id="origin" name="'origin" class="form-control" disabled>
            <option>Seleccione...</option>
        </select>
    </div>
    <!-- End  textfield -->
  </div>
  <div class="row">
    <!-- Begin  textfield -->
    <div class="form-group">
        {!! Form::label('warehouseDestination', 'Almacen de Destino:') !!}
        <select id="destination" name="'destination" class="form-control" disabled>
            <option>Seleccione...</option>
        </select>
    </div>
    <!-- End  textfield -->
  </div>
  <div class="row">
    <!-- Begin fechaDesde textfield -->
    <div class='col-sm-6'>
        <h3>Desde:</h3>
    </div>
    <div class='col-sm-6'>
        <h3>Hasta:</h3>
    </div>
    <!-- End fechaDesde textfield -->
  </div>
  <div class="row">
    <!-- Begin fechaDesde textfield -->
    <div class='col-sm-6'>
        <div class="form-group">
            <div class='input-group date' id='fechaDesde'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-sm-6'>
        <div class="form-group">
            <div class='input-group date' id='fechaHasta'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <!-- End fechaDesde textfield -->
  </div>

  <div class="row">
    <div class="form-group">
        {!! Form::submit('Ver Movimientos', ['class' => 'btn btn-primary form-control']) !!}
    </div>
  </div>
{{--

  <div class="row">
        <!-- Begin fechaHasta textfield -->
        <div class="form-group">
            <div class='input-group date' id='fechaHasta' name="fechaHasta">
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <!-- End fechaHasta textfield -->
  </div>

--}}
  {!! Form::close() !!}


@endsection

@section('scripts')

    <script src="/js/moment.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
    <script type="text/javascript">
    $(function () {
        $('#fechaDesde').datetimepicker();
        $('#fechaHasta').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#fechaDesde").on("dp.change", function (e) {
            $('#fechaHasta').data("DateTimePicker").minDate(e.date);
//            $(this).hide();
        });
        $("#fechaHasta").on("dp.change", function (e) {
            $('#fechaDesde').data("DateTimePicker").maxDate(e.date);
//            $(this).hide();
        });
        //El multiselector de empresas
          $('#companyList').select2({
            'placeholder'   :   'Clic para seleccionar una o varias empresas'
          });
        // fin de multiselector de empresas
        //El multiselector de articulos
          $('#articleList').select2({
            'placeholder'   :   'Clic para seleccionar uno o varios artículos'
          });
        // fin de multiselector de empresas

        $('form input[type=radio]').click(function()
        {
    //                Lleno el dropdown de almacén de origen cuando se selecciona la actividad
                var activity_id = $(this).val();
                $('#origin').empty()
                            .append($('<option>')
                            .text('Seleccione...')
                            .attr('value', ''));
                $('#destination').empty()
                            .append($('<option>')
                            .text('Seleccione...')
                            .attr('value', ''));

                var origin = $.ajax({
                  url: "/api/warehousesByActivity/" + activity_id,
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
                    $('#origin').attr('disabled', false);
                    $('#destination').attr('disabled', false);

                }); /* Fin del .done */

                origin.fail(function( jqXHR, textStatus ) {
                    alert( "Fallo cargando los almacenes. " + textStatus );
                });
        }); // fin del form input[type=radio]

        $('#origin').change(function()
        {

        }); // Fin del origin.change()

        $( "form" ).submit(function( event ) {
            event.preventDefault();
            var input = $('form input[type=radio]:checked').val();
            alert(input);
        });
    });
    function sortDropDownListByText(selectId) {
        var foption = $('#'+ selectId + ' option:first');
        var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b) {
           return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
        });
        $('#' + selectId).html(soptions).prepend(foption);

    };
    </script>
@endsection