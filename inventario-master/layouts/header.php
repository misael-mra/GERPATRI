<?php
$user = current_user();

// Add Javascript
// Scripts must be placed before including 'footer.php' and in the following format: $scripts .= "";
$scripts = null;
?>
<!DOCTYPE html>
  <html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Inventário";?>
    </title>

    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-html5-1.6.3/b-colvis-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/main.css" />
  </head>
  <body>
  <?php if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"> Inventário </div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?= strftime('%H:%M,  %d de %B de %Y', strtotime(make_date()));?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="assets/img/users/<?= $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?= remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="perfil.php?id=<?= (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Perfil
                  </a>
              </li>             
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Sair
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once('admin_menu.php');?>

      <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special user -->
      <?php include_once('operator_menu.php');?>      

      <?php endif;?>
    </div>

  <?php endif;?>

<div class="page">
  <div class="container-fluid">
