<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$types_item = find_by_id('description_assets',(int)$_POST['id']);
if(!$types_item){
  $session->msg("d","Descrição não encontrada!");
  redirect('descricao_bens.php');
}

$delete_id = delete_by_id('description_assets',(int)$types_item['id']);
if($delete_id){
  $session->msg("s","Descrição excluída com sucesso!");
  redirect('descricao_bens.php');
} else {
  $session->msg("d","Falha ao excluir o item.");
  redirect('descricao_bens.php');
}
?>
