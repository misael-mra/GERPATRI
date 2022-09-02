<?php
require_once('includes/load.php');

$page_title = 'Todas as Transferências';
// Checkin What level user has permission to view this page
page_require_level(2);

$transfers = find_all_transfer();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todas as Transferências</span>
        </strong>
        <div class="pull-right">
          <a href="adicionar_transferencia.php" class="btn btn-primary">Adicionar transferência</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable-active">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>                
              <th> Tombo</th>
              <th class="none"> Especificações </th>
              <th class="text-center"> Tipo de Equipamento </th>
              <th class="text-center"> Setor </th>
              <th class="text-center"> Usuário Responsável </th>
              <th class="text-center"> Data da transferência </th>
              <th class="text-center none"> Criado por </th>
              <th class="text-center none"> Criado em </th>
              <th class="text-center none"> Atualizado por </th>
              <th class="text-center none"> Atualizado em </th>
              <th class="text-center"> Ações </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transfers as $transfer):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td class="text-center"><?= remove_junk($transfer['tombo']); ?></td>
                <td><?= remove_junk($transfer['specifications']); ?></td>
                <td class="text-center"><?= remove_junk($transfer['type_equip']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['sector']); ?></td>                
                <td class="text-center"><?= remove_junk($transfer['responsible_user']); ?></td>                
                <td class="text-center"><?= strftime('%d/%m/%Y', strtotime($transfer['transfer_date'])); ?></td>
                <td><?= remove_junk($transfer['created_user']); ?></td>       
                <td class="text-center"><?= strftime('%d/%m/%Y %H:%M', strtotime($transfer['created_at'])); ?></td>                
                <td><?= remove_junk($transfer['updated_user']); ?></td>
                <td class="text-center"><?php if(!empty($transfer['updated_at'])) echo strftime('%d/%m/%Y %H:%M', strtotime($transfer['updated_at'])); ?></td>                
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_transferencia.php?id=<?= (int)$transfer['id'];?>" class="btn btn-xs btn-warning"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button title="Receber equipamento" type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#launchModal-<?= (int)$transfer['id'];?>">
                      <span class="glyphicon glyphicon-share-alt"></span>
                    </button>                    

                    <?php $action="finalizar_transferencia.php"; $id=(int)$transfer['id']; include('layouts/modal-confirmacao.php'); ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
