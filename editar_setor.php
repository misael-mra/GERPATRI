<?php
require_once('includes/load.php');

$page_title = 'Editar setor';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all sectors.
$sector = find_by_id('sectors',(int)$_GET['id']);
if(!$sector){
  $session->msg("d","Setor não encontrado!");
  redirect('setores.php');
}

if(isset($_POST['edit_sector'])){
  $req_field = array('sector-name');
  validate_fields($req_field);
  $sector_name = remove_junk($db->escape($_POST['sector-name']));
  if(empty($errors)){
    $sql = "UPDATE sectors SET name='{$sector_name}'";
    $sql .= " WHERE id='{$sector['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Setor alterado com sucesso!");
      redirect('setores.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar o setor.");
      redirect('setores.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('setores.php',false);
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
          <span>Editando <?= remove_junk(ucfirst($sector['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_setor.php?id=<?= (int)$sector['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="sector-name" required autocomplete="off" value="<?= remove_junk(ucfirst($sector['name']));?>">
          </div>
          <button type="submit" name="edit_sector" class="btn btn-primary">Atualizar setor</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
