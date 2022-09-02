<?php
require_once('includes/load.php');

$page_title = 'Todas as situações';
// Checkin What level user has permission to view this page
page_require_level(1);

$all_situations = find_all('situations');

if(isset($_POST['add_situation'])){
  $req_field = array('situation-name');
  validate_fields($req_field);
  $situation_name = remove_junk($db->escape($_POST['situation-name']));
  if(empty($errors)){
    $sql  = "INSERT INTO situations (name)";
    $sql .= " VALUES ('{$situation_name}')";
    if($db->query($sql)){
      $session->msg("s", "Situação adicionada com sucesso!");
      redirect('situacoes.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao cadastrar a situação.");
      redirect('situacoes.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('situacoes.php',false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Adicionar nova situação</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="situacoes.php">
          <div class="form-group">
            <input type="text" class="form-control" name="situation-name" placeholder="Nome da situação" required autocomplete="off">
          </div>
          <button type="submit" name="add_situation" class="btn btn-primary">Nova situação</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todas as situações</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Situações</th>
              <th class="text-center" style="width: 100px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_situations as $sit):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td><?= remove_junk(ucfirst($sit['name'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_situacao.php?id=<?= (int)$sit['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    <button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$sit['id'];?>">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <?php $action="deletar_situacao.php"; $id=(int)$sit['id']; include('layouts/modal-confirmacao.php'); ?>
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
