<?php
require_once('includes/load.php');

$page_title = 'Editar tipo de Item';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all types equipment.
$type_equip = find_by_id('description_assets',(int)$_GET['id']);
if(!$type_equip){
  $session->msg("d","Tipo de item não encontrado!");
  redirect('descricao_bens.php');
}

if(isset($_POST['edit_type_equip'])){
  $req_field = array('type_equip-name');
  validate_fields($req_field);
  $type_equip_name = remove_junk($db->escape($_POST['type_equip-name']));
  if(empty($errors)){
    $sql = "UPDATE description_assets SET name='{$type_equip_name}'";
    $sql .= " WHERE id='{$type_equip['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Tipo de item alterado com sucesso");
      redirect('descricao_bens.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar o tipo de item.");
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
          <span>Editando <?= remove_junk(ucfirst($type_equip['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_tipos_equipamento.php?id=<?= (int)$type_equip['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="type_equip-name" required autocomplete="off" value="<?= remove_junk(ucfirst($type_equip['name']));?>">
          </div>
          <button type="submit" name="edit_type_equip" class="btn btn-primary">Atualizar Item</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
