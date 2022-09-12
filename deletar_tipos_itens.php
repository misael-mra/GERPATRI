<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$sector = find_by_id('types_equips',(int)$_POST['id']);
if(!$sector){
  $session->msg("d","Tipo de equiapmento não encontrado!");
  redirect('tipos_equipamento.php');
}

$delete_id = delete_by_id('types_equips',(int)$sector['id']);
if($delete_id){
  $session->msg("s","Tipo de equiapmento excluído.");
  redirect('tipos_equipamento.php');
} else {
  $session->msg("d","Falha ao excluir o tipo de equiapmento.");
  redirect('tipos_equipamento.php');
}
?>
