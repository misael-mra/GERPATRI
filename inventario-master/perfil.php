<?php
require_once('includes/load.php');

$page_title = 'Meu Perfil';
// Checkin What level user has permission to view this page
page_require_level(2);

$user_id = (int)$_GET['id'];
if(empty($user_id)):
  redirect('dashboard.php',false);
else:
  $user_p = find_by_id('users',$user_id);
endif;
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-4">
    <div class="panel profile">
      <div class="jumbotron text-center bg-blue">
        <img class="img-circle img-size-2" src="assets/img/users/<?= $user_p['image'];?>" alt="Imagem do Perfil do Usuário">
        <h3><?= first_character($user_p['name']); ?></h3>
      </div>
      <?php if( $user_p['id'] === $user['id']):?>
        <ul class="nav nav-pills nav-stacked">
          <li><a class="btn btn-danger" href="editar_perfil.php"> <i class="glyphicon glyphicon-edit"></i> Editar perfil</a></li>
        </ul>
      <?php endif;?>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
