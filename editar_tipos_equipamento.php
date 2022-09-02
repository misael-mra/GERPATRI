<?php
require_once('includes/load.php');

$page_title = 'Editar tipo de equipamento';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all types equipment.
$type_equip = find_by_id('types_equips',(int)$_GET['id']);
if(!$type_equip){
  $session->msg("d","Tipo de equipamento não encontrado!");
  redirect('tipos_equipamento.php');
}

if(isset($_POST['edit_type_equip'])){
  $req_field = array('type_equip-name');
  validate_fields($req_field);
  $type_equip_name = remove_junk($db->escape($_POST['type_equip-name']));
  if(empty($errors)){
    $sql = "UPDATE types_equips SET name='{$type_equip_name}'";
    $sql .= " WHERE id='{$type_equip['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Tipo de equipamento alterado com sucesso");
      redirect('tipos_equipamento.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar o tipo de equipamento.");
      redirect('tipos_equipamento.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('tipos_equipamento.php',false);
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
          <span>Editando <?= remove_junk(ucfirst($type_equip['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_tipos_equipamento.php?id=<?= (int)$type_equip['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="type_equip-name" required autocomplete="off" value="<?= remove_junk(ucfirst($type_equip['name']));?>">
          </div>
          <button type="submit" name="edit_type_equip" class="btn btn-primary">Atualizar tipo de equipamento</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
