<?php
require_once('includes/load.php');

$req_fields = array('username','password' );
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    //create session with id
    $session->login($user_id);
    //Update Sign in time
    updateLastLogIn($user_id);
    redirect('dashboard.php',false);

  } else {
    $session->msg("d", "Desculpe, Usuário/Senha incorretos.");
    redirect('index.php',false);
  }

} else {
  $session->msg("d", $errors);
  redirect('index.php',false);
}

?>
