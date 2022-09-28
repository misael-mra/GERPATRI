<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$types_item = find_by_id('types_itens',(int)$_POST['id']);
if(!$types_item){
  $session->msg("d","Tipo de item não encontrado!");
  redirect('tipos_itens.php');
}

$delete_id = delete_by_id('types_itens',(int)$types_item['id']);
if($delete_id){
  $session->msg("s","Item excluído.");
  redirect('tipos_itens.php');
} else {
  $session->msg("d","Falha ao excluir o item.");
  redirect('tipos_itens.php');
}
?>
