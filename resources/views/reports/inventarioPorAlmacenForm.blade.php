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
    <h1>Artículos por Almacén - Alt</h1>
  </div>
</div>

    <hr/>

      {!! Form::open(['url' => '/reportes/inventarioPorAlmacen', 'id' => 'frm']) !!}

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
                 {!! Form::label('warehouse', 'Almacén:') !!}<br/>

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
                <select id="warehouse" name="warehouse" class="form-control" disabled>
                    <option>Seleccione...</option>
                </select>

            </div>
            <!-- End origin textfield -->
        </div>
 </div>
<div class="row">
    <div class="form-group col-sm-12">
        <input class="btn btn-primary col-sm-12" type="submit" id="btnValidate" name="btnValidate" value="Ver">
    </div>
</div>
{!! Form::close() !!}
<hr/>
@endsection

@section('scripts')
<script>
  $(function()
  {
        $('#frm input[name="rdActivity"]').change(function()
        {
//      Lleno el dropdown de almacén de origen cuando se selecciona la actividad
            loadWarehouses();
            $('#frm input[type="radio"][name="rdOrigin"]').attr('disabled', false);

        }); // fin del form input[type=radio]

        $('#frm input[name="rdOrigin"]').change(function()
        {
//            alert($('#warehosue').prop('disabled'));
            $('#warehouse').prop('disabled', function(i, v) { return !v; });
        });
  });  // Fin del document.ready()
  function sortDropDownListByText(selectId)
  {
      var foption = $('#'+ selectId + ' option:first');
      var soptions = $('#'+ selectId + ' option:not(:first)').sort(function(a, b) {
         return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
      });
      $('#' + selectId).html(soptions).prepend(foption);

  }
  function loadWarehouses()
  {
        var activity_id = $("#frm input[name='rdActivity']:checked").val();
        var company_id = $("#companyList").val();
        $('#warehouse').empty()
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

                if (result[k].type_id != '1')
                {
                    $('#warehouse').append($('<option>')
                                .text(result[k].name)
                                .attr('value', result[k].id));
                }

            } /* Fin del for */


            sortDropDownListByText('destination_id');
        //                $('#origin').attr('disabled', false);
        //                $('#destination').attr('disabled', false);

        });/* Fin del .done */



        origin.fail(function( jqXHR, textStatus ) {
            alert( "Fallo cargando los almacenes de origen " + textStatus );
        });
  }

</script>
@endsection