<?php
require_once('includes/load.php');

$page_title = 'Todos Usuários';
// Checkin What level user has permission to view this page
page_require_level(1);

//pull out all user form database
$all_users = find_all_user();
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
          <span>Usuários</span>
        </strong>
        <a href="adicionar_usuario.php" class="btn btn-info pull-right">Adicionar Usuário</a>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Nome </th>
              <th>Usuário</th>
              <th class="text-center" style="width: 15%;">Papel do Usuário</th>
              <th class="text-center" style="width: 10%;">Estado</th>
              <th style="width: 20%;">Último Login</th>
              <th class="text-center" style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($all_users as $a_user): ?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td><?= remove_junk(ucwords($a_user['name']))?></td>
                <td><?= remove_junk($a_user['username'])?></td>
                <td class="text-center"><?= remove_junk(ucwords($a_user['group_name']))?></td>
                <td class="text-center">
                  <?php if($a_user['status'] === '1'): ?>
                  <span class="label label-success"><?= "Ativo"; ?></span>
                  <?php else: ?>
                  <span class="label label-danger"><?= "Inativo"; ?></span>
                  <?php endif;?>
                </td>
                <td><?php if(empty($a_user['last_login'])): echo "Nunca fez login"; else: echo strftime('%H:%M,  %d de %B de %Y', strtotime($a_user['last_login'])); endif; ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_usuario.php?id=<?= (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
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
