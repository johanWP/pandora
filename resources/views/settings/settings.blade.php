@extends('master')

@section('title')
    Ajustes
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-10">
            <h1>Ajustes</h1>
        </div>
    </div>
    <hr/>
    {!! Form::open(['url' => '/ajustes/company', 'id' => 'frmCompany']) !!}
    <div class="row">
        <div class="col-sm-12" id="divMsjCompany"></div>
        <div class="form-group" id="divCompany">
            <p class="help-block">Usted está trabajando con <strong id="strCompany">{{ Auth::user()->currentCompany->name }}</strong></p>
            {!! Form::hidden('oldCompany', Auth::user()->current_company_id, ['id'=>'oldCompany']) !!}
            {!! Form::label('currentCompany', 'Cambiar:') !!}
            {!! Form::select('newCompany', $companies , null, ['class' => 'form-control', 'id'=>'newCompany', 'placeholder'=>'Seleccione...']) !!}
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnCompany">Cambiar Empresa</button>
        </div>
    </div>
    {!! Form::close() !!}
    <hr/>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function ()
        {
            $('#divMsjCompany').html('')
                            .removeClass('alert alert-danger')
                            .slideUp('slow');
            $('#btnCompany').click(function ()
            {
                var oldCompany = $('#oldCompany').val();
                var newCompany = $('#newCompany').val();
                var valid = true;
                $('#frmCompany div').removeClass('has-error');
                var mensaje;
                if (oldCompany == newCompany) {
                    mensaje = 'Ambas empresas son iguales. Prueba seleccionar una distinta.';
                    $('#divCompany').addClass('has-error');
                    valid = false;
                }
                if((newCompany == '') || (newCompany == 'Seleccione...'))
                {
                    mensaje = 'No hay una nueva empresa seleccionada. Prueba seleccionar una del menú.';
                    $('#divCompany').addClass('has-error');
                    valid = false;
                }

                if (valid)
                {
                    $.ajax({
                        method: "GET",
                        url: "/ajustes/cambiarEmpresa",
                        data:  $('#frmCompany').serialize()
                    })
                    .done(function( msg ) {
                        if (msg == '1')
                        {
                            mensaje = 'La empresa se ha cambiado.';
                            $('#strCompany').html($('#newCompany option:selected').text());
                            $('#spanCurrentCompanyName').html($('#newCompany option:selected').text());
                            $('#divMsjCompany').html(mensaje)
                                    .removeClass('alert alert-danger')
                                    .addClass('alert alert-success')
                                    .slideDown('slow')
                                    .delay(2000)
                                    .slideUp(250);;
                        } else
                        {
                            mensaje = 'Hubo un error al procesar el cambio.  Intenta más tarde';
                            $('#divMsjCompany').html(mensaje)
                                    .addClass('alert alert-danger')
                                    .slideDown('slow')
                                    .delay(2000)
                                    .slideUp(250);;
                        }
                    });
                } else  //  si no hay errores en el formulario
                {
                    $('#divMsjCompany').html(mensaje)
                                .addClass('alert alert-danger')
                                .slideDown('slow')
                                .delay(2000)
                                .slideUp(250);;
                }

            });
        }); // Fin del document.ready
    </script>
@endsection