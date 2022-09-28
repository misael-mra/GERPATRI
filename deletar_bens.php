<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

$asset_del = find_by_id('assets',(int)$_POST['id']);
if(!$asset_del){
	$session->msg("d","Bem não encontrado!");
	redirect('bens.php');
}

$delete_id = delete_by_id('assets',(int)$asset_del['id']);
if($delete_id){
	$session->msg("s","Bem excluído com sucesso!");
	redirect('bens.php');
} else {
	$session->msg("d","Falha ao excluir o bem.");
	redirect('bens.php');
}
?>
