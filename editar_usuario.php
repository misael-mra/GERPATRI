<?php
require_once('includes/load.php');

$page_title = 'Editar Usuário';
// Checkin What level user has permission to view this page
page_require_level(1);

$e_user = find_by_id('users',(int)$_GET['id']);
$groups  = find_all('user_groups');
if(!$e_user){
  $session->msg("d","Usuário não encontrado.");
  redirect('usuarios.php');
}

//Update User basic info
if(isset($_POST['update'])) {
  $req_fields = array('name','username','level');
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$e_user['id'];
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));
    $level = (int)$db->escape($_POST['level']);
    $status   = remove_junk($db->escape($_POST['status']));
    $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Usuário alterado com sucesso!");
      redirect('usuarios.php?id='.(int)$e_user['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar o usuário.');
      redirect('editar_usuario.php?id='.(int)$e_user['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_usuario.php?id='.(int)$e_user['id'],false);
  }
}

// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$e_user['id'];
    $password = remove_junk($db->escape($_POST['password']));
    $h_pass   = sha1($password);
    $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Senha alterada com sucesso! ");
      redirect('usuarios.php?id='.(int)$e_user['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar a senha.');
      redirect('editar_usuario.php?id='.(int)$e_user['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_usuario.php?id='.(int)$e_user['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12"> <?= display_msg($msg); ?> </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Atualizar conta de <?= remove_junk(ucwords($e_user['name'])); ?>
        </strong>        
      </div>
      <div class="panel-body">
        <form method="post" action="editar_usuario.php?id=<?= (int)$e_user['id'];?>" class="clearfix">
          <div class="form-group">
            <label for="name" class="control-label">Nome</label>
            <input type="name" class="form-control" name="name" value="<?= remove_junk(ucwords($e_user['name'])); ?>" required>
          </div>
          <div class="form-group">
            <label for="username" class="control-label">Usuário</label>
            <input type="text" class="form-control" name="username" value="<?= remove_junk($e_user['username']); ?>" required>
          </div>
          <div class="form-group">
            <label for="level">Papel do Usuário</label>
            <select class="form-control" name="level" required>
              <?php foreach ($groups as $group ):?>
                <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?= $group['group_level'];?>"><?= ucwords($group['group_name']);?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" required>
              <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Ativo</option>
              <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Inativo</option>
            </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
            <a href="usuarios.php" class="btn btn-danger">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Change password form -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Alterar senha de <?= remove_junk(ucwords($e_user['name'])); ?>
        </strong>
      </div>
      <div class="panel-body">
        <form action="editar_usuario.php?id=<?= (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
            <label for="password" class="control-label">Senha</label>
            <input type="password" class="form-control" name="password" placeholder="Digite a nova senha" required>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update-pass" class="btn btn-info pull-right">Atualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
