<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['method' => 'DELETE', 'id'=>'frmDelete']) !!}
      <div class="modal-body">
        <p>Esta seguro que quiere borrar <b></b>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Eliminar</button>
      </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
<script>
    $( document ).ready(function() {

    var baseFolder = window.location.pathname + '/';
    $('#modalConfirm').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('name') // Extract info from data-* attributes
      var deleteId = button.data('deleteme') // Extract info from data-* attributes
      var modal = $(this)
      modal.find('.modal-body b').text(recipient)
      $('#frmDelete').attr('action', baseFolder + deleteId);
    })}); // Fin del document.ready()

</script>