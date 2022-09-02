<?php
require_once('includes/load.php');

$page_title = 'Editar fabricante';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all manufacturers.
$manufacturer = find_by_id('manufacturers',(int)$_GET['id']);
if(!$manufacturer){
  $session->msg("d","Fabricante não encontrado!");
  redirect('fabricantes.php');
}

if(isset($_POST['edit_manufacturer'])){
  $req_field = array('manufacturer-name');
  validate_fields($req_field);
  $manufacturer_name = remove_junk($db->escape($_POST['manufacturer-name']));
  if(empty($errors)){
    $sql = "UPDATE manufacturers SET name='{$manufacturer_name}'";
    $sql .= " WHERE id='{$manufacturer['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Fabricante alterado com sucesso!");
      redirect('fabricantes.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar o fabricante.");
      redirect('fabricantes.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('fabricantes.php',false);
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
          <span>Editando <?= remove_junk(ucfirst($manufacturer['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_fabricante.php?id=<?= (int)$manufacturer['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="manufacturer-name" required autocomplete="off" value="<?= remove_junk(ucfirst($manufacturer['name']));?>">
          </div>
          <button type="submit" name="edit_manufacturer" class="btn btn-primary">Atualizar fabricante</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
