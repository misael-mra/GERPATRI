<?php
require_once('includes/load.php');

$page_title = 'Editar Grupo';
// Checkin What level user has permission to view this page
page_require_level(1);

$e_group = find_by_id('user_groups',(int)$_GET['id']);
if(!$e_group){
  $session->msg("d","Grupo não encontrado");
  redirect('grupos.php');
}

if(isset($_POST['update'])){

  $req_fields = array('group-name','group-level');
  validate_fields($req_fields);
  if(empty($errors)){
    $name = remove_junk($db->escape($_POST['group-name']));
    $level = remove_junk($db->escape($_POST['group-level']));
    $status = remove_junk($db->escape($_POST['status']));

    $query  = "UPDATE user_groups SET ";
    $query .= "group_name='{$name}',group_level='{$level}',group_status='{$status}'";
    $query .= "WHERE ID='{$db->escape($e_group['id'])}'";
    $result = $db->query($query);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Grupo alterado com sucesso!");
      redirect('grupos.php?id='.(int)$e_group['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar o grupo.');
      redirect('editar_grupo.php?id='.(int)$e_group['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_grupo.php?id='.(int)$e_group['id'], false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
  <div class="text-center">
    <h3>Editar Grupo</h3>
  </div>
  <?= display_msg($msg); ?>
  <form method="post" action="editar_grupo.php?id=<?= (int)$e_group['id'];?>" class="clearfix">
    <div class="form-group">
      <label for="name" class="control-label">Nome do Grupo</label>
      <input type="name" class="form-control" name="group-name" value="<?= remove_junk(ucwords($e_group['group_name'])); ?>" required>
    </div>
    <div class="form-group">
      <label for="level" class="control-label">Nível do Grupo</label>
      <input type="number" class="form-control" name="group-level" value="<?= (int)$e_group['group_level']; ?>" required>
    </div>
    <div class="form-group">
      <label for="status">Estado</label>
      <select class="form-control" name="status" required>
        <option <?php if($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Ativo </option>
        <option <?php if($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0"> Inativo </option>
      </select>
    </div>
    <div class="form-group clearfix">
      <button type="submit" name="update" class="btn btn-info">Atualizar</button>
      <a href="grupos.php" class="btn btn-danger">Cancelar</a>
    </div>
  </form>
</div>

<?php include_once('layouts/footer.php'); ?>
