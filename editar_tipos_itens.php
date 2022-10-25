<?php
require_once('includes/load.php');

$page_title = 'Editar tipo de Item';
// Checkin What level user has permission to view this page
page_require_level(1);

//Display all types equipment.
$types_item = find_by_id('types_itens',(int)$_GET['id']);
if(!$types_item){
  $session->msg("d","Tipo de item não encontrado!");
  redirect('tipos_itens.php');
}

if(isset($_POST['edit_types_item'])){
  $req_field = array('item-name');
  $t_item_name = remove_junk($db->escape($_POST['item-name']));
  if(empty($errors)){
    $sql = "UPDATE types_itens SET name='{$t_item_name}'";
    $sql .= " WHERE id='{$types_item['id']}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1) {
      $session->msg("s", "Tipo de item alterado com sucesso");
      redirect('tipos_itens.php',false);
    } else {
      $session->msg("d", "Desculpe, falha ao alterar o tipo de item.");
      redirect('tipos_itens.php',false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('tipos_itens.php',false);
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
          <span>Editando <?= remove_junk(ucfirst($types_item['name']));?></span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_tipos_itens.php?id=<?= (int)$types_item['id'];?>">
          <div class="form-group">
            <input type="text" class="form-control" name="item-name" required autocomplete="off" value="<?= remove_junk(ucfirst($types_item['name']));?>">
          </div>
          <button type="submit" name="edit_types_item" class="btn btn-success">Atualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>
