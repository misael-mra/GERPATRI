<div class="modal fade" tabindex="-1" role="dialog" id="launchModal-<?= $id; ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?= $action; ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Confirmar solicitação</h4>
        </div>
        <div class="modal-body">
          <p class="text-left">Você tem certeza que deseja realizar esta ação?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

          <input type="hidden" name="id" value="<?= $id; ?>">
          <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
      </form>
    </div>
  </div>
</div>