@extends('master')

@section('title')
    Importar Artículos
@endsection

@section('content')
<div class="row">
  <div class="col-sm-10">
    <h1>Importar Artículos</h1>
  </div>
</div>

    <hr/>
<div class="row">
    <p>El sistema puede importar masivamente una lista de artículos e incluirlos automáticamente en la base de datos.
    Use en archivo de Excel con extensión <strong>.xlsx</strong> o <strong>.xls</strong> con la información ordenada
    de la siguiente manera.</p>
    <table class="table table-responsive table-bordered">
      <thead>
          <tr>
              <th>Codigo</th>
              <th>Descripcion</th>
              <th>U/B</th>
              <th>Barcode</th>
              <th>Fav</th>
              <th>Serializable</th>
              <th>activo</th>

          </tr>
      </thead>
      <tbody>
          <tr>
              <td>Codigo del Artículo</td>
              <td>Nombre del Artículo</td>
              <td>Unidad de Medida (M, K, L, U)</td>
              <td>Código de barras (si está disponible)</td>
              <td>Favorito (0, 1)</td>
              <td>Serializable (0, 1)</td>
              <td>activo (0, 1)</td>

          </tr>
      </tbody>
    </table>
</div>

<div class="row">

  {!! Form::open(['action' => ['ImportController@importArticles'], 'method' => 'POST', 'id'=>'formuploadajax', 'files'=>true]) !!}
  <div class="form-group-sm">
    <label for="myfile">Seleccione el archivo Excel con el formato especificado.</label>
    <input type="file" id="myfile" name="myfile">
    <p class="help-block">Sólo se permiten archivos con extensiones .xls y .xlsx</p>
  </div>

  <div class="form-group-sm">
    {!! Form::submit('Subir archivo', ['class'=>'btn btn-primary']); !!}
  </div>
  {!! Form::close() !!}
</div>

{{--

fileuploader:
<div id="fileuploader">Upload</div>
--}}
@endsection

@section('scripts')
{{--

<link href="/css/uploadfile.css" rel="stylesheet">
<script src="/js/jquery.uploadfile.min.js"></script>
      <script>
      $(function(){
         $("#fileuploader").uploadFile(
         {
            url:"/import/articles",
            multiple:true,
            dragDrop:true,
            fileName:"myfile",
            abortStr:"Abortar",
            cancelStr:"Cancelar",
            doneStr:"Terminado"

         });
      });   // fin del document.ready
      </script>

--}}
@endsection