@extends('master')

@section('title')
    Ajustes
@endsection
@section('css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

@endsection
@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Actualizar Artículos Activos</h1>
        </div>
    </div>
    <hr/>
    <p>Los artículos que no hayan tenido movimientos entre las fechas seleccionadas se marcarán como inactivos y no podrán tener movimientos.
     Esta acción no puede deshacerse.</p>
    {!! Form::open(['url' => '/ajustes/actualizarArticulosActivos', 'id' => 'frm']) !!}
    <div class="row">
        <!-- Begin fechaDesde textfield -->
        <div class='col-sm-6' id="divFechaDesde">
            <label>Desde:</label>
            <div class="form-group">
                <input type='text' class="form-control"  id='fechaDesde' name='fechaDesde' readonly />
            </div>
        </div>
        <!-- End fechaDesde textfield -->
        <!-- Begin fechaHasta textfield -->
        <div class='col-sm-6' id="divFechaHasta">
            <label>Hasta:</label>
            <div class="form-group">
                <input type='text' class="form-control"  id='fechaHasta' name='fechaHasta' readonly/>
            </div>
        </div>
        <!-- End fechaHasta textfield -->
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            <button class="btn btn-primary col-sm-12" type="button" id="btnValidate" name="btnValidate">Marcar Artículos</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')

    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/datepicker-es.js"></script>

    <script type="text/javascript">
        $(function ()
        {
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

            $('#btnValidate').click(function()
            {
                var frm = $('#frm');
                valid = validate();
                if(valid)
                {
                    $(this).html('<i class="fa fa-cog fa-spin"></i> Espere...')
                            .attr('disabled', 'disabled');
                    frm.submit();
                }
            });
            function validate()
            {
                var valid = true;
                $('#frm div').removeClass('has-error');

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
        });
    </script>
@endsection