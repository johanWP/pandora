@extends('master')

@section('title')
    Movimientos por Usuario
@endsection

@section('css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Movimientos por Usuario</h1>
        </div>
    </div>

    <hr/>

    {!! Form::open(['url' => '/reportes/movimientosPorUsuario', 'id' => 'frm']) !!}
    <div class="row">
        <!-- Begin Company textfield -->
        <div class="form-group" id="divCompany">

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
    <hr/>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group" id="divUser">
                {!! Form::label('user', 'User:') !!}<br/>

                <label class="radio-inline">
                    <input type="radio" name="rdUser" id="rdUserAll" value="all" checked disabled>
                    Todos los usuarios
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rdUser" id="rdUserOne" value="one" disabled>
                    Seleccione un usuario
                </label>
                <!-- Begin origin textfield -->
                <p></p>
                {!! Form::select('user', $users , null, ['class' => 'form-control', 'id'=>'user', 'placeholder'=>'Seleccione...', 'disabled'=>'disabled']) !!}
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

            var company_id = $('#companyList').val();

            if ( company_id !='')
            {
                $('input[type="radio"][name="rdUser"]').attr('disabled', false);

            }
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


            $('form input[name="rdUser"]').change(function(){
                $('#user').prop('disabled', function(i, v) { return !v; });

            });


            $('#btnValidate').click(function()
            {
                var frm = $('#frm');
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
// Empresa
            var company_id = $("#companyList").val();
            if(company_id == '' )
            {
                $('#divCompany').addClass('has-error');
                valid = false;
            }

// Un Usuario o todos?
            var rdUser = $("input[name='rdUser']:checked").val();
            if((rdUser=='one') && ($('#user').val()==='Seleccione...' || ($('#user').val()==='') ))
            {
                $('#divUser').addClass('has-error');
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