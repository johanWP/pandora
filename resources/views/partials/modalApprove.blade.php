<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="approveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url'=>'movimientos/aprobar', 'method' => 'POST', 'id'=>'frmApprove']) !!}
      <div class="modal-body">
        <p>¿Está seguro que quiere aprobar este movimiento?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
        var btn;

        $('#modalApprove').on('show.bs.modal', function (event) {
            btn = $(event.relatedTarget);
            var button = $(event.relatedTarget); // Button that triggered the modal
            //              var recipient = button.data('name'); // Extract info from data-* attributes
            approveId = button.data('id');// Extract info from data-* attributes
            var modal = $(this);
            modal.find('.btn-primary').attr('disabled', false);
            $('#id').val(button.data('id'));

        });

        var frm = $('#frmApprove');

        frm.submit(function (ev) {
        //$('#frmApprove').hide();
         ev.preventDefault();

        $.ajax({
            method: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize()
        })
          .done(function( msg ) {
            $('#modalApprove').modal('hide');
            id = $('#id').val();
            $("#tr_"+id).fadeOut('slow');
            rowCount = $('#table_'+id).length;
//            alert(rowCount);
            if(rowCount == 1)
            {
              $("."+id).fadeOut('slow');
            }
          })

    });


    }); // Fin del document.ready()

</script>