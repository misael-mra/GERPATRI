<?php
require_once('includes/load.php');

$page_title = 'Todos os Itens';
// Verifica se o usuário tem permissão para acessar essa página
page_require_level(1);

$assets = find_all_asset();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?= display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os bens</span>
        </strong>
        <div class="pull-right">
          <a href="adicionar_bens.php" class="btn btn-primary">Adicionar Novo</a>
        </div>
      </div>
      <div class="panel-body table-responsive" style="font-size:12px;">
        <table class="table table-bordered datatable-active"  style="width: 100%;">
          <thead>
            <tr>
              <th class="text-center" style="max-width: 40px"> #</th>                
              <th class="text-center" style="max-width: 60px"> Nº Tombo</th>
              <th class="text-center" style="max-width: 600px"> Descrição </th>
              <th class="text-center"> Tipo </th>
              <th class="text-center none"> Fabricante: </th>
              <th class="text-center none"> Situação: </th>
              <th class="text-center none"> Observação: </th>
              <th class="text-center none"> Término da Garantia: </th>
              <th class="text-center none"> Criado por: </th>
              <th class="text-center none"> Criado em: </th>
              <th class="text-center none"> Atualizado por: </th>
              <th class="text-center none"> Atualizado em: </th>
              <th class="text-center"> Ações </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($assets as $asset):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td class="text-center"><?= remove_junk($asset['tombo']); ?></td>
                <td><?= remove_junk($asset['descrip_asset']); ?></td>
                <td class="text-center"><?= remove_junk($asset['type_item']); ?></td>                
                <td class="text-center"><?= remove_junk($asset['manufacturer']); ?></td>                
                <td class="text-center"><?= remove_junk($asset['situation']); ?></td>                
                <td><?= remove_junk($asset['obs']); ?></td>
                <td class="text-center">
                  <?php
                    if(!is_null($asset['warranty'])) echo strftime('%d/%m/%Y', strtotime($asset['warranty']));
                    else echo "Sem garantia";
                  ?>                    
                </td>
                <td><?= remove_junk($asset['created_user']); ?></td>       
                <td class="text-center"><?= strftime('%d/%m/%Y %H:%M', strtotime($asset['created_at'])); ?></td>                
                <td><?= remove_junk($asset['updated_user']); ?></td>
                <td class="text-center"><?php if(!empty($asset['updated_at'])) echo strftime('%d/%m/%Y %H:%M', strtotime($asset['updated_at'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_bens.php?id=<?= (int)$asset['id'];?>" class="btn btn-xs btn-warning"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    <button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$asset['id'];?>">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <?php $action="deletar_bens.php"; $id=(int)$asset['id']; include('layouts/modal-confirmacao.php'); ?>
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
