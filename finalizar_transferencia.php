<?php
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(2);

$d_transfer = find_by_id('transfers',(int)$_POST['id']);

if(!$d_transfer){
  $session->msg("d","Transferência não encontada!");
  redirect('transferencias.php');
}

$delete_id = delete_by_id('transfers',(int)$d_transfer['id']);
if($delete_id){
  $a_id      = $db->escape((int) $d_transfer['asset_id']);
  $a_r_u     = $db->escape($d_transfer['responsible_user']);
  $a_sector  = $db->escape((int) $d_transfer['sector_id']);
  $a_t_date      = $db->escape($d_transfer['transfer_date']);
  $a_user_create = (int) $_SESSION['user_id'];
  $a_date_create = make_date();

  $sql  = "INSERT INTO transfer_historys (";
  $sql .= " asset_id, responsible_user, sector_id, transfer_date, created_by, created_at";
  $sql .= ") VALUES (";
  $sql .= "'{$a_id}','{$a_r_u}','{$a_sector}','{$a_t_date}','{$a_user_create}','{$a_date_create}'";
  $sql .= ")";

  if(!$db->query($sql)){
    $session->msg('d','Desculpe, falha ao adicionar a transferência no histórico de transferências.');
    redirect('adicionar_transferencia.php', false);
  }          

  $session->msg("s","Equipamento recebido com sucesso.");
  redirect('transferencias.php');

} else {
  $session->msg("d","Falha ao finalizar a transferência.");
  redirect('transferencias.php');
}
?>