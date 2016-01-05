<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="approveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url'=>'movimientos/aprobar', 'method' => 'POST', 'id'=>'frmApprove']) !!}
      <div class="modal-body">
        <p>¿Está seguro que quiere <span></span> este movimiento?</p>
        <label for="note">Nota:</label>
        <textarea class="form-control" rows="2" id="note" name="note"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger has-spinner" id="btnReject" name="btnReject"><i class="fa fa-close"></i> Rechazar</button>
        <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit"><i class="fa fa-check fa-fw"></i> Aprobar</button>
      </div>
        {!! Form::hidden('id', '0', ['name'=>'id', 'id'=>'id']); !!}
       {!! Form::close() !!}
    </div>
  </div>
</div>
<script>
    $( document ).ready(function()
    {
        var button;

        $('#modalApprove').on('show.bs.modal', function (event) {
            btn = $(event.relatedTarget);
            button = $(event.relatedTarget); // Button that triggered the modal
            var accion = button.data('name'); // Extract info from data-* attributes
            approveId = button.data('id');// Extract info from data-* attributes
            var modal = $(this);
            modal.find('span').html(accion);
            modal.find('textarea').val(button.data('note'));

            if (accion == 'aprobar')
            {
              modal.find('.btn-danger').hide();
              modal.find('.btn-primary').show();
              $('#frmApprove').attr('action', '/movimientos/aprobar');

            } else
            {
              modal.find('.btn-danger').show();
              modal.find('.btn-primary').hide();
              $('#frmApprove').attr('action', '/movimientos/rechazar');
            }
            modal.find('.btn-primary').attr('disabled', false);
            $('#id').val(button.data('id'));

        });

        var frm = $('#frmApprove');

        frm.submit(function (ev)
        {
            //$('#frmApprove').hide();
             ev.preventDefault();

            $.ajax({
                method: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize()
            })
              .done(function( msg ) {
                console.log(msg);
                button.closest('tr').fadeOut('slow', function() {
                    $(this).remove();
                });
                $('#modalApprove').modal('hide');
                rowCount = button.closest('table').children().children().length;
                var ticket = button.data('ticket');
                if(rowCount == 2)
                {
                  button.closest('table').fadeOut('slow');
                  $('.'+ ticket).fadeOut('slow');
                }
              })

        });

        $('#btnReject').click(function(){
            frm.submit();
        });
    }); // Fin del document.ready()

</script>