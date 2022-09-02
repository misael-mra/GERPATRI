<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$manufacturer = find_by_id('equipments',(int)$_POST['id']);
if(!$manufacturer){
	$session->msg("d","Equipamento não encontrado!");
	redirect('equipamentos.php');
}

$delete_id = delete_by_id('equipments',(int)$manufacturer['id']);
if($delete_id){
	$session->msg("s","Equipamento excluído.");
	redirect('equipamentos.php');
} else {
	$session->msg("d","Falha ao excluir o equipamento.");
	redirect('equipamentos.php');
}
?>
