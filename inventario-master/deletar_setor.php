<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$sector = find_by_id('sectors',(int)$_POST['id']);
if(!$sector){
  $session->msg("d","Setor não encontrado!");
  redirect('setores.php');
}

$delete_id = delete_by_id('sectors',(int)$sector['id']);
if($delete_id){
  $session->msg("s","Setor excluído.");
  redirect('setores.php');
} else {
  $session->msg("d","Falha ao excluir o setor.");
  redirect('setores.php');
}
?>
