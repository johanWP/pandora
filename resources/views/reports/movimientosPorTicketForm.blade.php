@extends('master')

@section('title')
    Movimientos por Ticket
@endsection

@section('css')
  <link rel="stylesheet" href="/css/jquery-ui.min.css">

@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Movimientos por Ticket</h1>
  </div>
{{--  <div class=""><br/>
    <a class="btn btn-primary" href="#"><i class="fa fa-file-excel-o fa-fw"></i> Exportar</a>
  </div>--}}
</div>

    <hr/>

  {!! Form::open(['url' => '/reportes/movimientosPorTicket', 'id' => 'frm']) !!}
<div class="row">
    <!-- Begin Company textfield -->
    <div class="form-group" id="divCompany">

    {!! Form::label('companyList', 'Empresas:') !!}
    @if(Auth::user()->company->parent==1)

{{--Si el usuario es de una empresa parent, le muestro un dropdown para seleccionar la empresa--}}
        {!! Form::select('companyList', $companies , null, ['class' => 'form-control', 'id'=>'companyList', 'placeholder'=>'Seleccione...']) !!}
    @else
{{--Si el usuario no es de una empresa parent, le preselecciono la empresa--}}

        {!! Form::text('company', Auth::user()->company->name, ['class' => 'form-control', 'readonly']) !!}
        {!! Form::hidden('companyList', Auth::user()->company_id, ['id' => 'companyList']) !!}
    @endif

    </div>
    <!-- End Company textfield -->
</div>
<hr/>

<div class="row">
        <div class="col-sm-12">
            <div class="form-group" id="divTicket">
                 {!! Form::label('ticket', 'Ticket:') !!}<br/>

                 <label class="radio-inline">
                    <input type="radio" name="rdTicket" id="rdTicketAll" value="all" checked disabled>
                    Todos los tickets
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="rdTicket" id="rdTicketOne" value="one" disabled>
                    Seleccione un ticket
                  </label>
                <!-- Begin origin textfield -->
                <p></p>
                {!! Form::select('ticket', $tickets , null, ['class' => 'form-control', 'id'=>'ticket', 'placeholder'=>'Seleccione...', 'disabled'=>'disabled']) !!}
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
        <input class="btn btn-primary col-sm-12" type="button" id="btnValidate" name="btnValidate" value="Ver">
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

        var company_id = $('#companyList').val();

        $('#companyList').change(function()
        {

            if ( $(this).val() !='')
            {
                $('input[type="radio"][name="rdTicket"]').attr('disabled', false);
            } else
            {
                $('input[type="radio"][name="rdTicket"]').attr('disabled', 'disabled');
            }
        });
        if ( company_id !='')
        {
            $('input[type="radio"][name="rdTicket"]').attr('disabled', false);

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


        $('form input[name="rdTicket"]').change(function(){
            $('#ticket').prop('disabled', function(i, v) { return !v; });

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

// Almacen Destino
        var rdTicket = $("input[name='rdTicket']:checked").val();
        if((rdTicket=='one') && ($('#ticket').val()==='Seleccione...' || ($('#ticket').val()==='') ))
        {
            $('#divTicket').addClass('has-error');
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

    }

  </script>
@endsection