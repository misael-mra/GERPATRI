<?php
require_once('includes/load.php');

$page_title = 'Editar Situação';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all situations.
$situation = find_by_id('situations',(int)$_GET['id']);
if(!$situation){
  $session->msg("d","Situação não encontrada!");
  redirect('situacoes.php');
}

if(isset($_POST['edit_situation'])){
  $req_field = array('situation-name');
  validate_fields($req_field);
  $situation_name = remove_junk($db->escape($_POST['situation-name']));
  if(empty($errors)){
    $sql = "UPDATE situations SET name='{$situation_name}'";
    $sql .= " WHERE id='{$situation['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Situação alterada com sucesso");
      redirect('situacoes.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar a situação.");
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
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editando <?= remove_junk(ucfirst($situation['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_situacao.php?id=<?= (int)$situation['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="situation-name" required autocomplete="off" value="<?= remove_junk(ucfirst($situation['name']));?>">
          </div>
          <button type="submit" name="edit_situation" class="btn btn-primary">Atualizar situação</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
