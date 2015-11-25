<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="approveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['method' => 'PUT', 'id'=>'frmApprove']) !!}
      <div class="modal-body">
        <p>Esta seguro que quiere aprobar <b></b>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Aprobar</button>
      </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
<script>
    $( document ).ready(function() {

    var baseFolder = window.location.pathname + '/';
    $('#modalApprove').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('name') // Extract info from data-* attributes
      var approveId = button.data('approveme') // Extract info from data-* attributes
      var modal = $(this)
      modal.find('.modal-body b').text(recipient)
      $('#frmApprove').attr('action', baseFolder + approveId);
    })}); // Fin del document.ready()

</script>