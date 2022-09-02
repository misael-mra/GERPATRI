<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$manufacturer = find_by_id('manufacturers',(int)$_POST['id']);
if(!$manufacturer){
  $session->msg("d","Fabricante não encontrado!");
  redirect('fabricantes.php');
}

$delete_id = delete_by_id('manufacturers',(int)$manufacturer['id']);
if($delete_id){
  $session->msg("s","Fabricante excluído.");
  redirect('fabricantes.php');
} else {
  $session->msg("d","Falha ao excluir o fabricante.");
  redirect('fabricantes.php');
}
?>
