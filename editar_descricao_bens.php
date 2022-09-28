<?php
require_once('includes/load.php');

$page_title = 'Editar descrição';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all types equipment.
$descripition_asset = find_by_id('description_assets',(int)$_GET['id']);
if(!$descripition_asset){
  $session->msg("d","Item não encontrado!");
  redirect('descricao_bens.php');
}

if(isset($_POST['edit_descripition_asset'])){
  $req_field = array('descripition_asset-name');
  $descripition_asset_name = remove_junk($db->escape($_POST['descripition_asset-name']));
  if(empty($errors)){
    $sql = "UPDATE description_assets SET name='{$descripition_asset_name}'";
    $sql .= " WHERE id='{$descripition_asset['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Descrição alterada com sucesso");
      redirect('descricao_bens.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar a descrição.");
      redirect('descricao_bens.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('descricao_bens.php',false);
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
          <span class="glyphicon glyphicon-edit"></span>
          <span>Editando <?= remove_junk(ucfirst($descripition_asset['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_descricao_bens.php?id=<?= (int)$descripition_asset['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="descripition_asset-name" required autocomplete="off" value="<?= remove_junk(ucfirst($descripition_asset['name']));?>">
          </div>
          <button type="submit" name="edit_descripition_asset" class="btn btn-success">Atualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
