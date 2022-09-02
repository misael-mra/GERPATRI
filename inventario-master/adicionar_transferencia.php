<?php
require_once('includes/load.php');

$page_title = 'Adicionar Transferência';
// Checkin What level user has permission to view this page
page_require_level(2);
?>
<?php

if(isset($_POST['add_transfer'])){
  $req_fields = array('e_id','sector','responsible_user','transfer_date');
  validate_fields($req_fields);
  if(empty($errors)){
    $e_id      = $db->escape((int) $_POST['e_id']);
    $e_r_u     = $db->escape($_POST['responsible_user']);
    $e_sector  = $db->escape((int) $_POST['sector']);
    $e_t_date      = $db->escape($_POST['transfer_date']);
    $e_user_create = (int) $_SESSION['user_id'];
    $e_date_create = make_date();

    $sql  = "INSERT INTO transfers (";
    $sql .= " equipment_id,responsible_user,sector_id,transfer_date,created_by,created_at";
    $sql .= ") VALUES (";
    $sql .= "'{$e_id}','{$e_r_u}','{$e_sector}','{$e_t_date}','{$e_user_create}','{$e_date_create}'";
    $sql .= ")";

    if($db->query($sql)){
      $session->msg('s',"Transferência adicionada com sucesso!");
      redirect('adicionar_transferencia.php', false);
    } else {
      $session->msg('d','Desculpe, falha ao adicionar o transferência');
      redirect('adicionar_transferencia.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('adicionar_transferencia.php',false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?= display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
      <div class="form-group">
        <div class="input-group">
          <input type="text" id="sug_input" class="form-control" name="tombo"  placeholder="Informe o tombo do equipamento">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Buscar equipamento</button>
          </span>            
        </div>
        <div id="result" class="list-group"></div>
      </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Adicionar transferência</span>
        </strong>
        <div class="pull-right">
          <a href="transferencias.php" class="btn btn-danger">Listar transferência</a>
        </div>
      </div>
      <div class="panel-body">
        <form method="post" action="adicionar_transferencia.php">
          <table class="table table-bordered">
            <thead>
              <th> Tombo </th>
              <th> Tipo de Equipamento</th>
              <th> Usuário Responsável </th>
              <th> Setor </th>
              <th> Data da transferência</th>
              <th> Ação</th>
            </thead>
            <tbody  id="equipment_info"> </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
