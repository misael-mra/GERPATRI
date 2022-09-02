<?php
require_once('includes/load.php');

$page_title = 'Adicionar Usuário';
// Checkin What level user has permission to view this page
page_require_level(1);
$groups = find_all('user_groups');
?>
<?php
if(isset($_POST['add_user'])){

  $req_fields = array('full-name','username','password','level' );
  validate_fields($req_fields);

  if(empty($errors)){
    $name   = remove_junk($db->escape($_POST['full-name']));
    $username   = remove_junk($db->escape($_POST['username']));
    $password   = remove_junk($db->escape($_POST['password']));
    $user_level = (int)$db->escape($_POST['level']);
    $password = sha1($password);
    $query = "INSERT INTO users (";
    $query .="name,username,password,user_level,status";
    $query .=") VALUES (";
    $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
    $query .=")";
    if($db->query($query)){
      $session->msg('s',"A conta do usuário $name foi criada com sucesso!");
      redirect('usuarios.php', false);
    } else {
      $session->msg('d','Desculpe, falha ao adicionar o usuário.');
      redirect('adicionar_usuario.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('adicionar_usuario.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<?= display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Adicionar Usuário</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="adicionar_usuario.php">
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" name="full-name" placeholder="Nome Completo" required>
          </div>
          <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" class="form-control" name="username" placeholder="Usuário" required>
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" name ="password"  placeholder="Senha" required>
          </div>
          <div class="form-group">
            <label for="level">Papel do Usuário</label>
            <select class="form-control" name="level" required>
              <?php foreach ($groups as $group ):?>
                <option value="<?= $group['group_level'];?>"><?= ucwords($group['group_name']);?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="add_user" class="btn btn-primary">Adicionar Usuário</button>
            <a href="usuarios.php" class="btn btn-danger">Cancelar</a>
          </div>
        </form>
      </div>

    </div>

  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
