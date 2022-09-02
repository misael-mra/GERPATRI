<?php
require_once('includes/load.php');

$page_title = 'Todos os Grupos';
// Checkin What level user has permission to view this page
page_require_level(2);

  $all_groups = find_all('user_groups');
  ?>

  <?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-12">
      <?= display_msg($msg); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Grupos</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Nome do Grupo</th>
                <th class="text-center" style="width: 20%;">Nível do Grupo</th>
                <th class="text-center" style="width: 15%;">Estado</th>
                <th class="text-center" style="width: 100px;">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($all_groups as $a_group): ?>
                <tr>
                  <td class="text-center"><?= count_id();?></td>
                  <td><?= remove_junk(ucwords($a_group['group_name']))?></td>
                  <td class="text-center">
                    <?= remove_junk(ucwords($a_group['group_level']))?>
                  </td>
                  <td class="text-center">
                    <?php if($a_group['group_status'] === '1'): ?>
                    <span class="label label-success"><?= "Ativo"; ?></span>
                    <?php else: ?>
                    <span class="label label-danger"><?= "Inativo"; ?></span>
                    <?php endif;?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="editar_grupo.php?id=<?= (int)$a_group['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                        <i class="glyphicon glyphicon-edit"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <?php include_once('layouts/footer.php'); ?>
