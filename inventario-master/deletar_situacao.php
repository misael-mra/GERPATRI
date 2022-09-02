<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$situation = find_by_id('situations',(int)$_POST['id']);
if(!$situation){
  $session->msg("d","Situação não encontrada!");
  redirect('situacoes.php');
}

$delete_id = delete_by_id('situations',(int)$situation['id']);
if($delete_id){
  $session->msg("s","Situação excluída.");
  redirect('situacoes.php');
} else {
  $session->msg("d","Falha ao excluir a situação.");
  redirect('situacoes.php');
}
?>
