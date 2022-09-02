<?php
require_once('includes/load.php');

$page_title = 'Editar Perfil';
page_require_level(2);

//update user image
if(isset($_POST['submit'])) {
  $photo = new Upload();
  $user_id = (int)$_POST['user_id'];
  $photo->upload_file($_FILES['file_upload']);
  if($photo->process_user($user_id)){
    $session->msg('s','Foto do perfil atualizada.');
    redirect('editar_perfil.php');
  } else{
    $session->msg('d',join($photo->errors));
    redirect('editar_perfil.php');
  }
}

//update user other info
if(isset($_POST['update-profile'])){
  $req_fields = array('name','username' );
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$_SESSION['user_id'];
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));
    $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Perfil atualizado!");
      redirect('editar_perfil.php', false);
    } else {
      $session->msg('d','Desculpe, não foi possível atualizar o seu perfil.');
      redirect('editar_perfil.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_perfil.php',false);
  }
}

// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('id-pass','password');
  validate_fields($req_fields);
  if(empty($errors)){
    $id = (int)$_POST['id-pass'];
    $password = remove_junk($db->escape($_POST['password']));
    $h_pass   = sha1($password);
    $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if($result && $db->affected_rows() === 1){
      $session->msg('s',"Senha alterada com sucesso! ");
      redirect('editar_perfil.php', false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar a senha.');
      redirect('editar_perfil.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_perfil.php',false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?= display_msg($msg); ?>
  </div>
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-heading clearfix">
          <span class="glyphicon glyphicon-camera"></span>
          <span>Alterar minha foto</span>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4">
            <img class="img-circle img-size-2" src="assets/img/users/<?= $user['image'];?>" alt="">
          </div>
          <div class="col-md-8">
            <form class="form" action="editar_perfil.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="file_upload" multiple="multiple" required class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?= $user['id'];?>">
                <button type="submit" name="submit" class="btn btn-warning">Atualizar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Editar Perfil</span>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_perfil.php" class="clearfix">
          <div class="form-group">
            <label for="name" class="control-label">Nome</label>
            <input type="name" class="form-control" name="name" placeholder="Nome completo" value="<?= remove_junk(ucwords($user['name'])); ?>" required>
          </div>
          <div class="form-group">
            <label for="username" class="control-label">Usuário</label>
            <input type="text" class="form-control" name="username" placeholder="Usuário" value="<?= remove_junk($user['username']); ?>" required>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update-profile" class="btn btn-info">Atualizar</button>
          </div>
        </form>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-lock"></span>
        <span>Alterar Senha</span>
      </div>
      <div class="panel-body">
        <form method="post" action="editar_perfil.php" class="clearfix">
          <input type="hidden" name="id-pass" value="<?= (int)$user['id']; ?>">
          <div class="form-group">
            <label for="password" class="control-label">Senha</label>
            <input type="password" class="form-control" name="password" placeholder="Digite a nova senha" required>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update-pass" class="btn btn-danger">Atualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<?php include_once('layouts/footer.php'); ?>
